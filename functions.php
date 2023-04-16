<?php

include_once 'connection.php';
function add_book($title, $author1Id, $author2Id, $grade, $isRead): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO books (title, grade, is_read) VALUES (?, ?, ?)");
    $stmt->execute([$title, $grade, $isRead]);

    $last_id = $conn->lastInsertId();
    if (!empty($author1Id)) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
        $stmt->execute([$last_id, $author1Id]);
    }
    if (!empty($author2Id)) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
        $stmt->execute([$last_id, $author2Id]);
    }
}

function add_author($firstName, $lastName, $grade): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO authors (firstName, lastname, grade) VALUES (?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $grade]);
}


function find_book_by_id($id): ?array
{
    $conn = getConnection();
    $stmt = $conn->prepare("
select books.title, concat(authors.firstname , ' ', authors.lastname)
    from books_authors 
    join books on books.id = books_authors.book_id
    join authors on authors.id=books_authors.author_id
                                    where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $book = $stmt->fetch();
    return $book ?: null;
}


function update_book(int $id, string $title, int $author1Id, int $author2Id, int $grade, int $isRead): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE books SET title = ?, grade = ?, is_read = ? WHERE id = ?");
    $stmt->execute([$title, $grade, $isRead, $id]);
    $stmt = $conn->prepare("DELETE FROM books_authors WHERE book_id = ?");
    $stmt->execute([$id]);

    if (($author1Id) != null) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
        $stmt->execute([$id, $author1Id]);
    }
    if (($author2Id) != null) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
        $stmt->execute([$id, $author2Id]);
    }
}

function update_author($id, $firstName, $lastName, $grade): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE authors SET firstname = ?, lastname = ?, grade = ? WHERE id = ?");
    $stmt->execute([$firstName, $lastName, $grade, $id]);
}

function getBookById($id): array
{
    $conn = getConnection();
    $stmt = $conn->prepare("select * from books where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}


function getAuthorById($id): array
{
    $conn = getConnection();
    $stmt = $conn->prepare("select * from authors where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getBooksAuthorsById($id): array
{
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT books.title, authors.id as 'author_id', authors.firstname, authors.lastname, books.grade, books.is_read
FROM books_authors
JOIN books ON books.id = books_authors.book_id
JOIN authors ON authors.id = books_authors.author_id
WHERE books.id = :id;
");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll();
}

function deleteBook($id): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("delete from books_authors where book_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $stmt = $conn->prepare("delete from books where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

function deleteAuthor($id): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("delete from books_authors where author_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $stmt = $conn->prepare("delete from authors where id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

//$id = 1;
//$book = getBooksAuthorsById($id);
//var_dump($book[0]);
//$a = (getAuthorById($book[0][$id])['firstname']);
//var_dump($a);
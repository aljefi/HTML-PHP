<?php

include_once 'connection.php';
function add_book($title, $author1Id, $author2Id, $grade, $isRead): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO books (title, grade, is_read) VALUES (:title, :grade, :isRead)");
    $stmt->bindParam(':title', $title);
    $grade = intval($grade);
    $stmt->bindParam(':grade', $grade);
    if ($isRead != null){
        $isRead = boolval($isRead);
    }
    $stmt->bindParam(':isRead', $isRead);
    $stmt->execute();

    $last_id = $conn->lastInsertId();

    if (!empty($author1Id)) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (:last_id, :author1Id)");
        $stmt->bindParam(':last_id', $last_id);
        $author1Id = intval($author1Id);
        $stmt->bindParam(':author1Id', $author1Id);
        $stmt->execute();
    }

    if (!empty($author2Id)) {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (:last_id, :author2Id)");
        $stmt->bindParam(':last_id', $last_id);
        $stmt->bindParam(':author2Id', $author2Id);
        $stmt->execute();
    }
}

function add_author($firstName, $lastName, $grade): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO authors (firstname, lastname, grade) VALUES (:firstName, :lastName, :grade)");
    $stmt->bindParam('firstName', $firstName);
    $stmt->bindParam('lastName', $lastName);
    $grade = intval($grade);
    $stmt->bindParam('grade', $grade);
    $stmt->execute();
}

function update_book($id, $title, $author1Id, $author2Id, $grade, $isRead): void
{
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE books SET title = ?, grade = ?, is_read = ? WHERE id = ?");
    $stmt->execute([$title, $grade, $isRead, $id]);
    $stmt = $conn->prepare("DELETE FROM books_authors WHERE book_id = ?");
    $stmt->execute([$id]);

    if ($author1Id !== "") {
        $stmt = $conn->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
        $stmt->execute([$id, $author1Id]);
    }
    if ($author2Id !== "") {
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

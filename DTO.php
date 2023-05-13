<?php

include_once 'Author.php';
include_once 'Book.php';
include_once 'connection.php';

class DTO
{
    private PDO $db;

    public function __construct()
    {
        $this->db = getConnection();
    }

    public function getBooks(): array
    {
        $books = [];
        $stmt = $this->db->prepare("
        SELECT books.id, books.title, authors.id as author_id, authors.firstname, authors.lastname, books.grade, books.is_read
        FROM books
        LEFT JOIN books_authors ON books.id = books_authors.book_id
        LEFT JOIN authors ON authors.id = books_authors.author_id
        order by books.id, author_id
    ");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tempId = null;
        foreach ($result as $row) {
            if ($row['id'] != $tempId) {
                $book = new Book($row['title'], $row['grade'], $row['is_read']);
                $book->id = $row['id'];
                $books[] = $book;
            }
            $book->authors[] = new Author($row['firstname'], $row['lastname'], $row['author_id']);
            $tempId = $row['id'];
        }
        return $books;
    }


    public function addBook($title, $author1Id, $author2Id, $grade, $isRead): void
    {
        $stmt = $this->db->prepare("INSERT INTO books (title, grade, is_read) VALUES (:title, :grade, :isRead)");
        $stmt->bindParam(':title', $title);
        $grade = intval($grade);
        $stmt->bindParam(':grade', $grade);
        if ($isRead != null) {
            $isRead = boolval($isRead);
        }
        $stmt->bindParam(':isRead', $isRead);
        $stmt->execute();

        $last_id = $this->db->lastInsertId();

        if (!empty($author1Id)) {
            $stmt = $this->db->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (:last_id, :author1Id)");
            $stmt->bindParam(':last_id', $last_id);
            $author1Id = intval($author1Id);
            $stmt->bindParam(':author1Id', $author1Id);
            $stmt->execute();
        }

        if (!empty($author2Id)) {
            $stmt = $this->db->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (:last_id, :author2Id)");
            $stmt->bindParam(':last_id', $last_id);
            $stmt->bindParam(':author2Id', $author2Id);
            $stmt->execute();
        }
    }

    public function update_book($id, $title, $author1Id, $author2Id, $grade, $isRead): void
    {
        $stmt = $this->db->prepare("UPDATE books SET title = ?, grade = ?, is_read = ? WHERE id = ?");
        $stmt->execute([$title, $grade, $isRead, $id]);
        $stmt = $this->db->prepare("DELETE FROM books_authors WHERE book_id = ?");
        $stmt->execute([$id]);

        if ($author2Id !== "") {
            $stmt = $this->db->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
            $stmt->execute([$id, $author2Id]);
        }
        if ($author1Id !== "") {
            $stmt = $this->db->prepare("INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)");
            $stmt->execute([$id, $author1Id]);
        }
    }

    public function deleteBook($id): void
    {
        $stmt = $this->db->prepare("delete from books_authors where book_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt = $this->db->prepare("delete from books where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getBookById($id): Book
    {
        $stmt = $this->db->prepare("select * from books where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        $book = new Book($result['title'], $result['grade'], $result['is_read']);
        $book->id = $result['id'];

        return $book;
    }

    public function getBooksAuthorsById($id): array
    {
        $authors = [];
        $stmt = $this->db->prepare("
SELECT books.title, authors.id as 'author_id', authors.firstname, authors.lastname, books.grade, books.is_read
FROM books_authors
JOIN books ON books.id = books_authors.book_id
JOIN authors ON authors.id = books_authors.author_id
WHERE books.id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $author = new Author($row['firstname'], $row['lastname'], $row['grade']);
            $author->id = $row['author_id'];
            $authors[] = $author;
        }
        return ($authors);
    }

    public function getAuthors(): array
    {
        $authors = [];
        $stmt = $this->db->prepare("SELECT id, firstname, lastname, grade FROM authors;");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $author = new Author($row['firstname'], $row['lastname'], $row['grade']);
            $author->id = $row['id'];
            $authors[] = $author;
        }
        return $authors;
    }

    public function add_author($firstName, $lastName, $grade): void
    {
        $stmt = $this->db->prepare("INSERT INTO authors (firstname, lastname, grade) VALUES (:firstName, :lastName, :grade)");
        $stmt->bindParam('firstName', $firstName);
        $stmt->bindParam('lastName', $lastName);
        $grade = intval($grade);
        $stmt->bindParam('grade', $grade);
        $stmt->execute();
    }

    public function update_author($id, $firstName, $lastName, $grade): void
    {
        $stmt = $this->db->prepare("UPDATE authors SET firstname = ?, lastname = ?, grade = ? WHERE id = ?");
        $stmt->execute([$firstName, $lastName, $grade, $id]);
    }

    public function deleteAuthor($id): void
    {
        $stmt = $this->db->prepare("delete from books_authors where author_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt = $this->db->prepare("delete from authors where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getAuthorById($id): Author
    {
        $stmt = $this->db->prepare("select * from authors where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        $author = new Author($result['firstname'], $result['lastname'], $result['grade']);
        $author->id = $result['id'];

        return $author;
    }

}

//$dto = new DTO();
//$books = $dto->getAuthors();
//var_dump($books);

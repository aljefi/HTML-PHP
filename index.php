<?php
include_once 'Request.php';
include_once 'DTO.php';
include_once 'vendor/tpl.php';

$dto = new DTO();

$request = new Request($_REQUEST);
$cmd = $request->param('cmd')
    ? $request->param('cmd')
    : 'show_book_list';


if ($cmd === 'show_book_list') {
    $books = $dto->getBooks();
    $message = "";
    if (isset($_GET['success']) && $_GET['success'] == '1') {
        $message = "Raamatu lisamine õnnestus!";
    } else if (isset($_GET['success']) && $_GET['success'] == '2') {
        $message = "Updated!";
    } else if (isset($_GET['success']) && $_GET['success'] == '3') {
        $message = "Kustutatud!";
    }
    $data = [
        'pageTitle' => 'Raamatud',
        'template' => 'main.html',
        'pageId' => 'book-list-page',
        'contentPath' => 'book-list.html',
        'books' => $books,
        'message' => $message
    ];
    print renderTemplate('tpl/main.html', $data);

} elseif ($cmd === 'show_author_list') {
    $authors = $dto->getAuthors();

    $message = "";
    if (isset($_GET['success']) && $_GET['success'] == '1') {
        $message = "Autori lisamine õnnestus!";
    } else if (isset($_GET['success']) && $_GET['success'] == '2') {
        $message = "Updated!";
    } else if (isset($_GET['success']) && $_GET['success'] == '3') {
        $message = "Kustutatud!";
    }
    $data = [
        'pageTitle' => 'Autorid',
        'template' => 'main.html',
        'pageId' => 'author-list-page',
        'contentPath' => 'author-list.html',
        'authors' => $authors,
        'message' => $message
    ];
    print renderTemplate('tpl/main.html', $data);

} elseif ($cmd === 'show_book_edit') {
    $book = $dto->getBookById($_GET['id']);
    $authors = $dto->getAuthors();
    $book_authors = $dto->getBooksAuthorsById($_GET['id']);
    $id = $_GET['id'] ?? null;
    $title = '';
    $grade = '';
    $isRead = '';
    $message = "";
    $author1Id = ($_POST['author1']) ?? "";
    $author2Id = ($_POST['author2']) ?? "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleteButton'])) {
            $dto->deleteBook($id);
            header('Location: index.php?success=3');
            exit();
        }
        $title = $_POST['title'] ?? "";
        $author1Id = $_POST['author1'] ?? null;
        $author2Id = $_POST['author2'] ?? null;
        $grade = $_POST['grade'] ?? null;
        $isRead = $_POST['isRead'] ?? 0;
        $isRead = intval($isRead);
        if (strlen($title) < 3 || strlen($title) > 23) {
            $message = "Pealkiri peab olema vähemalt 3 ja mitte rohkem kui 23 tähemärki pikk.";
        } else {
            $dto->update_book($id, $title, $author1Id, $author2Id, $grade, $isRead);
            header('Location: index.php?success=2');
            exit();
        }
    }
    $author1 = $book_authors[0];
    $author2 = $book_authors[1];
    $data = [
        'pageTitle' => 'Raamatu muutmine',
        'template' => 'main.html',
        'pageId' => 'book-edit-page',
        'contentPath' => 'book-edit.html',
        'message' => $message,
        'book' => $book,
        'authors' => $authors, //all authors
        'book_authors' => $book_authors, // current book authors
        'author1' => ($author1 !== null) ? ($author1) : "",
        'author2' => ($author2 !== null) ? ($author2) : "",
    ];
    print renderTemplate('tpl/main.html', $data);

} elseif ($cmd === 'show_book_form') {
    $authors = $dto->getAuthors();
    $authorId = $_GET['id'] ?? null;
    $title = '';
    $author1Id = null;
    $author2Id = null;
    $grade = '';
    $isRead = '';
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = ($_POST['title']) ?? "";
        $author1Id = ($_POST['author1']) ?? "";
        $author2Id = ($_POST['author2']) ?? "";
        $grade = isset($_POST['grade']) ? intval($_POST['grade']) : null;
        $isRead = $_POST['isRead'] ?? 0;
        $book = new Book($title, $grade, $isRead);
        if (strlen($title) < 3 || strlen($title) > 23) {
            $message = "Pealkiri peab olema vähemalt 3 ja mitte rohkem kui 23 tähemärki pikk.";
        }
        if ($message == "") {
            $dto->addBook($title, $author1Id, $author2Id, $grade, $isRead);
            header('Location: ?cmd=show_book_list&success=1');
            exit();
        }
    } else {
        $book = new Book("", null, null);
    }
    $author1 = $author1Id ? $dto->getAuthorById($author1Id) : null;
    $author2 = $author2Id ? $dto->getAuthorById($author2Id) : null;
    $data = [
        'pageTitle' => 'Raamatu lisamine',
        'template' => 'main.html',
        'pageId' => 'book-form-page',
        'contentPath' => 'book-add.html',
        'authors' => $authors,
        'message' => $message,
        'book' => $book,
        'author1' => ($author1 !== null) ? ($author1) : "",
        'author2' => ($author2 !== null) ? ($author2) : "",
    ];
    print renderTemplate('tpl/main.html', $data);

} elseif ($cmd === 'show_author_edit') {
    $author = $dto->getAuthorById($_GET['id']);
    $id = $_GET['id'] ?? null;
    $message = '';
    $firstName = $author->firstName;
    $lastName = $author->lastName;
    $grade = $author->grade;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleteButton'])) {
            $dto->deleteAuthor($id);
            header('Location: ?cmd=show_author_list&success=3');
            exit();
        }
        $firstName = $_POST['firstName'] ?? "";
        $lastName = $_POST['lastName'] ?? "";
        $grade = $_POST['grade'] ?? "";
        if (strlen($firstName) < 3 || strlen($firstName) > 23) {
            $message = "Eesnimi peab olema vähemalt 1 ja mitte rohkem kui 21 tähemärki pikk.";
        } else if (strlen($lastName) < 2 || strlen($lastName) > 22) {
            $message .= "\n";
            $message .= "Perekonnanimi peab olema vähemalt 2 ja mitte rohkem kui 22 tähemärki pikk.";
        } else {
            $dto->update_author($id, htmlspecialchars($firstName), htmlspecialchars($lastName), $grade);
            header('Location: ?cmd=show_author_list&success=2');
            exit();
        }
    }
    $data = [
        'pageTitle' => 'Autori muutmine',
        'template' => 'main.html',
        'pageId' => 'author-edit-page',
        'contentPath' => 'author-edit.html',
        'author' => $author,
    ];
    print renderTemplate('tpl/main.html', $data);

} elseif ($cmd === 'show_author_form') {
    $authors = $dto->getAuthors();
    $firstName = $_POST['firstName'] ?? "";
    $lastName = $_POST['lastName'] ?? "";
    $grade = $_POST['grade'] ?? null;
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (strlen($firstName) < 1 || strlen($firstName) > 21) {
            $message = "Eesnimi peab olema vähemalt 1 ja mitte rohkem kui 21 tähemärki pikk.";
        } else if (strlen($lastName) < 2 || strlen($lastName) > 22) {
            $message .= "\n";
            $message .= "Perekonnanimi peab olema vähemalt 2 ja mitte rohkem kui 22 tähemärki pikk.";
        }

        if ($message == "") {
            $dto->add_author($firstName, $lastName, $grade);
            header('Location: ?cmd=show_author_list&success=1');
            exit();
        }
    }
    $data = [
        'pageTitle' => 'Autori lisamine',
        'template' => 'main.html',
        'pageId' => 'author-form-page',
        'contentPath' => 'author-add.html',
        'authors' => $authors,
        'message' => $message,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'grade' => $grade
    ];
    print renderTemplate('tpl/main.html', $data);

} else {
    print $cmd;
    throw new Error('DTO error!');
}

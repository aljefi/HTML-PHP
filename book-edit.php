<?php

include_once 'functions.php';
include_once 'connection.php';
$id = $_GET['id'] ?? null;
$message = '';

$book = getBooksAuthorsById($id);
if (isset($id)){
    $title = getBookById($id)['title'] ?? "";
}
if (isset($book[0])) {
    $author1Id = $book[0]['author_id'] ?? "";
    $author1Name = getAuthorById($author1Id)['firstname'] . " " . getAuthorById($author1Id)['lastname'] ?? "";
} else {
    $author1Id = null;
    $author1Name = "Select an author";
}
if (isset($book[1])) {
    $author2Id = $book[1]['author_id'] ?? "";
    $author2Name = getAuthorById($author2Id)['firstname'] . " " . getAuthorById($author2Id)['lastname'] ?? "";
} else {
    $author2Id = null;
    $author2Name = "Select an author";
}
$grade = $book[0]['grade'] ?? "";
$isRead = $book[0]['is_read'] ?? 0;
$isRead = intval($isRead);

var_dump($author1Id);
var_dump($author2Id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteButton'])) {
        deleteBook($id);
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
        update_book($id, $title, $author1Id, $author2Id,  $grade, $isRead);
        header('Location: index.php?success=2');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lisa raamat</title>
</head>
<body id="book-edit-page">

<form action="book-edit.php?id=<?= $id ?>" method="post">


    <table border="0" width="100%">
        <tr>
            <td></td>
            <td width="800">
                <table border="0" width="100%">
                    <tr>
                        <td>
                            <?php include 'menu.php'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td id="error-block">
                            <?php echo $message; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>

                            <table border="0" width="75%" align="center">
                                <tr>
                                    <td width="12%">Pealkiri:</td>
                                    <td><input type="text" name="title" value="<?= $title ?>"> <br>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="12%">Author 1:</td>
                                    <td>
                                        <select id="author1" name="author1">
                                            <option value="<?= $author1Id ?? '' ?>"><?= $author1Name ? $author1Name : 'Select an author' ?></option>
                                            <?php
                                            $conn = getConnection();
                                            $stmt = $conn->prepare("select * from authors");
                                            $stmt->execute();
                                            $authors = $stmt->fetchAll();
                                            foreach ($authors as $author) {
                                                $id = $author['id'];
                                                $name = $author['firstname'] . ' ' . $author['lastname'];
                                                if ($id == $author1Id) {
                                                    continue;
                                                }
                                                echo "<option value='$id'>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="12%">Author 2:</td>
                                    <td>
                                        <select id="author2" name="author2">
                                            <option value="<?= $author2Id ?? '' ?>"><?= $author2Name ? $author2Name : 'Select an author' ?></option> <?php
                                            $conn = getConnection();
                                            $stmt = $conn->prepare("select * from authors");
                                            $stmt->execute();
                                            $authors = $stmt->fetchAll();
                                            foreach ($authors as $author) {
                                                $id = $author['id'];
                                                $name = $author['firstname'] . ' ' . $author['lastname'];
                                                if ($id == $author2Id) {
                                                    continue;
                                                }
                                                echo "<option value='$id'>$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="12%">Hinne:</td>
                                    <td>
                                        <input type="radio" name="grade"
                                               value="1" <?php echo $grade == 1 ? 'checked' : '' ?>>1
                                        <input type="radio" name="grade"
                                               value="2" <?php echo $grade == 2 ? 'checked' : '' ?>>2
                                        <input type="radio" name="grade"
                                               value="3" <?php echo $grade == 3 ? 'checked' : '' ?>>3
                                        <input type="radio" name="grade"
                                               value="4" <?php echo $grade == 4 ? 'checked' : '' ?>>4
                                        <input type="radio" name="grade"
                                               value="5" <?php echo $grade == 5 ? 'checked' : '' ?>>5
                                    </td>
                                </tr>
                                <tr>
                                    <td width="12%">Loetud:</td>
                                    <td><input type="checkbox" name="isRead"
                                               value="1" <?php echo $isRead == 'yes' ? 'checked' : ''; ?>>
                                        <br></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="right"><input name="deleteButton" type="submit" value="Kustuta"></td>
                                    <td align="right"><input name="submitButton" type="submit" value="Salvesta"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <br>
                            <table border="0" width="100%">
                                <tr>
                                    <td width="33%">ICD0007 Näidisrakendus</td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
    </table>

</form>

</body>
</html>
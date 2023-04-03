<?php

include_once 'functions.php';
$id = $_GET['id'] ?? null;
$message = '';

$book = find_book_by_id($id);
$title = $book["title"];
$author = $book["author"];
$grade = $book["grade"];
$isRead = $book["isRead"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteButton'])) {
        delete_item(BOOKS_FILE, $id);
        header('Location: index.php?success=3');
        exit();
    }
    $title = $_POST['title'] ?? "";
    $author = $_POST['author'] ?? "";
    $grade = $_POST['grade'] ?? "";
    $isRead = isset($_POST['isRead']) ? 'yes' : 'no';
    if (strlen($title) < 3 || strlen($title) > 23) {
        $message = "Pealkiri peab olema vähemalt 3 ja mitte rohkem kui 23 tähemärki pikk.";
    } else {
        update_book($id, htmlspecialchars($title), htmlspecialchars($author), $grade, $isRead);
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

    <input type="hidden" name="id" value="<?= $id ?>">

    <?php include 'menu.php'; ?>

    <div id="error-block">
        <?php echo $message; ?>
    </div>

    <br>

    <table border="0" width="75%" align="center">
        <tr>
            <td width="12%">Pealkiri:</td>
            <td><input type="text" name="title" value="<?= $title ?>"> <br>
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
                       value="yes" <?php echo $isRead == 'yes' ? 'checked' : ''; ?>>
                <br></td>
        </tr>
        <tr>
            <td></td>
            <td align="right"><input name="deleteButton" type="submit" value="Kustuta"></td>
            <td align="right"><input name="submitButton" type="submit" value="Salvesta"></td>
        </tr>
    </table>

    <br>

    <div>
        ICD0007 Näidisrakendus
    </div>

</form>

</body>
</html>

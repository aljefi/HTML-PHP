<?php

include_once 'functions.php';
$id = $_GET['id'] ?? null;
$title = '';
$author = '';
$grade = '';
$isRead = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? "";
    $author = $_POST['author'] ?? "";
    $grade = $_POST['grade'] ?? "";
    $isRead = isset($_POST['isRead']) ? 'yes' : 'no';
    if (strlen($title) < 3 || strlen($title) > 23) {
        $message = "Pealkiri peab olema vähemalt 3 ja mitte rohkem kui 23 tähemärki pikk.";
    }

    if ($message == "") {
        add_book(htmlspecialchars($title), htmlspecialchars($author), $grade, $isRead);
        header('Location: index.php?success=1');
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
<body id="book-form-page">

<form action="book-add.php" method="post">


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
<?php

include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'] ?? " ";
    $grade = $_POST['grade'] ?? " ";
    $isRead = isset($_POST['isRead']) ? 'yes' : 'no';

    add_book(base64_encode($title), base64_encode($author), $grade, $isRead);

    header('Location: index.php');
    exit();
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


    <table border="1" width="100%">
        <tr>
            <td></td>
            <td width="800">
                <table border="1" width="100%">
                    <tr>
                        <td>
                            <?php include 'menu.php'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>

                            <table border="1" width="75%" align="center">
                                <tr>
                                    <td width="12%">Pealkiri:</td>
                                    <td><input type="text" name="title"> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="12%">Hinne:</td>
                                    <td>
                                        <input type="radio" name="grade" value="1">1
                                        <input type="radio" name="grade" value="2">2
                                        <input type="radio" name="grade" value="3">3
                                        <input type="radio" name="grade" value="4">4
                                        <input type="radio" name="grade" value="5">5
                                    </td>
                                </tr>
                                <tr>
                                    <td width="12%">Loetud:</td>
                                    <td><input type="checkbox" name="isRead" value="yes"> <br></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="right"><input name="submitButton" type="submit" value="Saada"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>

                            <br>
                            <table border="1" width="100%">
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
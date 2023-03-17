<?php

include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $grade = $_POST['grade'] ?? " ";


    add_author(base64_encode($firstName), base64_encode($lastName), $grade);

    header('Location: author-list.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lisa author</title>
</head>
<body id="author-form-page">

<form action="author-add.php" method="post">

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

                            <table width="30%" align="center">
                                <tr>
                                    <td align="right">
                                        Eesnimi:
                                    </td>
                                    <td>
                                        <input type="text" name="firstName"> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        Perekonnanimi:
                                    </td>
                                    <td>
                                        <input type="text" name="lastName"> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        Hinne:
                                    </td>
                                    <td>
                                        <input type="radio" name="grade" value="1">1
                                        <input type="radio" name="grade" value="2">2
                                        <input type="radio" name="grade" value="3">3
                                        <input type="radio" name="grade" value="4">4
                                        <input type="radio" name="grade" value="5">5
                                    </td>
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
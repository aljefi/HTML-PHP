<?php

include_once 'functions.php';
include_once 'connection.php';

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
        add_author(htmlspecialchars($firstName), htmlspecialchars($lastName), $grade);

        header('Location: author-list.php?success=1');
        exit();
    }

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
                        <td id="error-block">
                            <?php echo $message; ?>
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
                                        <input type="text" name="firstName" value="<?= $firstName ?>"> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        Perekonnanimi:
                                    </td>
                                    <td>
                                        <input type="text" name="lastName" value="<?= $lastName ?>"> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        Hinne:
                                    </td>
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
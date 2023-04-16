<?php
include_once 'connection.php';
include_once 'functions.php';
$id = $_GET['id'] ?? null;
$message = '';

$author = getAuthorById($id);
$firstName = $author["firstname"];
$lastName = $author["lastname"];
$grade = $author["grade"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteButton'])) {
        deleteAuthor( $id);
        header('Location: author-list.php?success=3');
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
        update_author($id, htmlspecialchars($firstName), htmlspecialchars($lastName), $grade);
        header('Location: author-list.php?success=2');
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
<body id="author-edit-page">

<form action="author-edit.php?id=<?= $id ?>" method="post">

<!--    <input type="hidden" name="id" value="--><?php //= $id ?><!--">-->

    <?php include 'menu.php'; ?>

    <div id="error-block">
        <?php echo $message; ?>
    </div>

    <br>

    <table border="0" width="75%" align="center">
        <tr>
            <td width="12%">Pealkiri:</td>
            <td><input type="text" name="firstName" value="<?= $firstName ?>"> <br>
            </td>
        </tr>
        <tr>
            <td width="12%">Pealkiri:</td>
            <td><input type="text" name="lastName" value="<?= $lastName ?>"> <br>
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

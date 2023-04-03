<?php

$message = "";
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $message = "Raamatu lisamine õnnestus!";
} else if (isset($_GET['success']) && $_GET['success'] == '2') {
    $message = "Updated!";
}else if (isset($_GET['success']) && $_GET['success'] == '3') {
    $message = "Kustutatud!";
}

$data = file_get_contents('books.txt');

$lines = explode("\n", $data);

$html = '';
foreach ($lines as $line) {
    if (!empty($line)) {
        list($id, $title, $author, $grade) = explode('|', $line);

        $title = htmlspecialchars_decode($title);
        $author = htmlspecialchars_decode($author);
        $id = urlencode($id);
        $html .= "<tr>";
        $html .= "<td width='33%'> <a href='book-edit.php?id=$id'>$title</a></td>";
        $html .= "<td width='33%'>$author</td>";
        $html .= "<td width='33%'>$grade</td>";
        $html .= "</tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raamatud</title>
</head>
<body id="book-list-page">


<table border="1" width="100%">
    <tr>
        <td></td>
        <td width="800px">
            <table border="1" width="100%">
                <tr>
                    <td>

                        <table border="1" width="100%">
                            <tr>
                                <td>
                                    <?php include 'menu.php'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td id="message-block">
                                    <?php echo $message; ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <table border="1" width="100%">
                            <tr>
                                <td width="33%">
                                    Pealkiri
                                </td>
                                <td width="33%">
                                    Autorid
                                </td>
                                <td width="33%">
                                    Hinne
                                </td>
                            </tr>
                            <tr>
                                <td width="33%">Head First Html and CSS</td>
                                <td width="33%">Elisabeth Robson, Eric Freeman</td>
                                <td width="33%">5</td>
                            </tr>
                            <?php echo $html; ?>
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


</body>
</html>
<?php

$data = file_get_contents('books.txt');

$lines = explode("\n", $data);

$html = '';
foreach ($lines as $line) {
    if (!empty($line)) {
        list($title, $author, $grade) = explode('|', $line);

        $title = base64_decode($title);
        $author = base64_decode($author);

        $html .= "<tr>";
        $html .= "<td width='33%'>$title</td>";
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
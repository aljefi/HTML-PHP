<?php

$data = file_get_contents('authors.txt');

$lines = explode("\n", $data);

$html = '';
foreach ($lines as $line) {
    if (!empty($line)) {
        list($firstName, $lastName, $grade) = explode('|', $line);

        $firstName = base64_decode($firstName);
        $lastName = base64_decode($lastName);

        $html .= "<tr>";
        $html .= "<td width='33%'>$firstName</td>";
        $html .= "<td width='33%'>$lastName</td>";
        $html .= "<td width='33%'>$grade</td>";
        $html .= "</tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Autorid</title>
</head>
<body id="author-list-page">

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

                        <table border="1" width="100%">
                            <tr>
                                <td>Nimi</td>
                                <td>Perekonnanimi</td>
                                <td>Hinne</td>
                            </tr>
                            <tr>
                                <td>Elisabeth</td>
                                <td>Robson</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>Eric</td>
                                <td>Freeman</td>
                                <td>5</td>
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
<?php
include_once 'connection.php';

$message = "";
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $message = "Raamatu lisamine õnnestus!";
} else if (isset($_GET['success']) && $_GET['success'] == '2') {
    $message = "Updated!";
} else if (isset($_GET['success']) && $_GET['success'] == '3') {
    $message = "Kustutatud!";
}

$conn = getConnection();
$stmt = $conn->prepare("
SELECT books.id, books.title, GROUP_CONCAT(CONCAT(authors.firstname, ' ', authors.lastname) SEPARATOR ', ') AS authors, books.grade, books.is_read
FROM books
LEFT JOIN books_authors ON books.id = books_authors.book_id
LEFT JOIN authors ON authors.id = books_authors.author_id
GROUP BY books.id;
");

$stmt->execute();
$books = $stmt->fetchAll();
$html = '';
foreach ($books as $book) {
    if (!empty($book)) {
        $title = htmlspecialchars_decode($book['title']);
        $author = isset($book['authors']) ? htmlspecialchars_decode($book['authors']) : '';
        $id = urlencode($book['id']);
        $grade = $book['grade'];
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


<table border="0" width="100%">
    <tr>
        <td></td>
        <td width="800px">
            <table border="0" width="100%">
                <tr>
                    <td>

                        <table border="0" width="100%">
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
                        <table border="0" width="100%">
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


</body>
</html>
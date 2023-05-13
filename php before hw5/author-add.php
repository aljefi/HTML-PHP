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
        add_author($firstName, $lastName, $grade);

        header('Location: author-list.php?success=1');
        exit();
    }

}

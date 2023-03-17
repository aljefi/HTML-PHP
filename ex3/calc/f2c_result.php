<?php

require_once 'functions.php';

$input = $_POST['temperature'] ?? null;

if ($input === null || $input === '') {
    $message = 'Insert temperature';
} else if (!is_numeric($input)) {
    $message = 'Temperature must be an integer';
} else {
    $inputTemp = floatval($input);

    $result = f2c($inputTemp);

    $message = sprintf("%d degrees in Fahrenheit is %d degrees in Celsius",
        $inputTemp, $result);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fahrenheit to Celsius</title>
</head>
<body>

<nav>
    <a href="index.html">Celsius to Fahrenheit</a> |
    <a href="f2c.html">Fahrenheit to Celsius</a>
</nav>

<main>

    <h3>Fahrenheit to Celsius</h3>

    <em><?= $message ?></em>

    <!--        <em>Insert temperature</em> /<br>-->
    <!--        <em>Temperature must be an integer</em> /<br>-->
    <!--        <em>x degrees in Fahrenheit is y degrees in Celsius</em>-->

</main>

</body>
</html>
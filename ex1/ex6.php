<?php

$inputFile = fopen(__DIR__ . "/data/temperatures-sample.csv", "r");
$outputFile = fopen(__DIR__ . "/temperatures-filtered.csv", "w");

while (!feof($inputFile)) {
    $dict = fgetcsv($inputFile);
    if ($dict[0] == "Aasta" or $dict[0] == 2004 or $dict[0] == 2021) {
        $data = ($dict[0] . " | " . $dict[1] . " | " . $dict[2] . " | "
            . explode(":", $dict[3])[0] . " | " . $dict[9]);
        var_dump($data);
        $all_data[]=$data.PHP_EOL;
    }
    file_put_contents('temperatures-filtered.csv', $all_data);
}

fclose($inputFile);
fclose($outputFile);


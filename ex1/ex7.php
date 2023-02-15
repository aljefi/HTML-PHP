<?php

function getDaysUnderTemp(int $targetYear, float $targetTemp): float
{
    $inputFile = fopen("data/temperatures-filtered.csv", "r");
    $count = 0;
    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if (!empty($dict) and intval($dict[0]) == $targetYear) {
            if ($dict[4] <= $targetTemp) {
                $count++;
            }
        }
    }
    $count = round($count / 24, 2);
    fclose($inputFile);
    return $count;
}

//print getDaysUnderTemp(2019, -10); // 13.92
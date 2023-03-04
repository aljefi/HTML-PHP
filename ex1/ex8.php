<?php

function getDaysUnderTempDictionary(float $targetTemp): array
{
    $inputFile = fopen(__DIR__ . '/data/temperatures-filtered.csv', "r");
    $ret = [];
    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if (!empty($dict) and $dict[4] <= $targetTemp) {
            $year = $dict[0];
            if (!isset($ret[$year])) {
                $ret[$year] = 1;
            } else {
                $ret[$year] += 1;
            }
        }
    }
    foreach ($ret as $year => $temp) {
        $ret[$year] = round($temp / 24, 2);
    }
    return $ret;
}

function dictToString(array $dict): string
{
    $ret = "[";
    foreach ($dict as $year => $temp) {
        $ret .= $year . " => " . $temp . ", ";
    }
    $ret = rtrim($ret, ', ');
    $ret .= "]";
    return $ret;
}

//$test = getDaysUnderTempDictionary(-10);
//var_dump($test);
//dictToString($test);
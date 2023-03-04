<?php

function getAverageWinterTemp(int $targetYear): float
{
    {
        $inputFile = fopen("../ex1/data/temperatures-filtered.csv", "r");
        $count = 0;
        $temp = 0;
        while (!feof($inputFile)) {
            $dict = fgetcsv($inputFile);
            if (!empty($dict) and intval($dict[0]) == $targetYear
                and ($dict[1] == 1 or $dict[1] == 2 or $dict[1] == 12)) {
                $temp += $dict[4];
                $count++;
            }
        }
        $temp = $temp / $count;
        fclose($inputFile);
        return $temp;
    }
}

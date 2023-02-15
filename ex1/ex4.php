<?php

$input = '[1, 4, 2, 0]';
$list = stringToIntegerList($input);

function stringToIntegerList(string $input): array
{
    $input = trim($input, "[]");
    $list = explode(", ", $input);

    foreach (range(0, count($list) - 1) as $num) {
        $list[$num] = intval($list[$num]);
    }
    return $list;
}

//var_dump(stringToIntegerList($input));
//// check that the restored list is the same as the input list.
//var_dump($list === [1, 4, 2, 0]); // should print "bool(true)"


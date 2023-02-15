<?php

$list = [1, 2, 3, 2, 6];

function isInList($list, $target): bool
{
    foreach ($list as $num) {
        if ($num === $target) return true;
    }
    return false;
}

//var_dump(isInList($list, 1)); // true
//var_dump(isInList($list, 2)); // true
//var_dump(isInList($list, '2')); // false
//var_dump(isInList($list, 4)); // false




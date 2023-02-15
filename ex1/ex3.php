<?php

$list = [1, 2, 3]; // "[1, 2, 3]"

function listToString(array $list): string
{
    return  "[" . join(", ", $list) . "]" ;
}

//print listToString($list);




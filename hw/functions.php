<?php

function add_book($title, $author, $grade, $read): void
{
    $file = fopen('books.txt', 'a');

    fwrite($file, $title . '|' . $author . '|' . $grade . '|' . $read . PHP_EOL);

    fclose($file);
}

function add_author($firstName, $lastName, $grade): void
{
    $file = fopen('authors.txt', 'a');

    fwrite($file, $firstName . '|' . $lastName . '|' . $grade . PHP_EOL);

    fclose($file);
}
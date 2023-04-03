<?php

const BOOKS_FILE = 'books.txt';
const AUTHORS_FILE = 'authors.txt';
function add_item($filename, $fields): void
{
    $file = fopen($filename, 'a+');

    $line_count = 0;
    while (!feof($file)) {
        $line = fgets($file);
        if ($line !== false) {
            $line_count++;
        }
    }
    $new_id = $line_count + 1;

    $fields = array_merge([$new_id], $fields);

    fwrite($file, implode('|', $fields) . PHP_EOL);

    fclose($file);
}

function add_book($title, $author, $grade, $isRead): void
{
    add_item(BOOKS_FILE, [$title, $author, $grade, $isRead]);
}

function add_author($firstName, $lastName, $grade): void
{
    add_item(AUTHORS_FILE, [$firstName, $lastName, $grade]);
}


function find_book_by_id($id): ?array
{
    $file = fopen(BOOKS_FILE, 'r');
    while (!feof($file)) {
        $line = fgets($file);
        if ($line !== false) {
            $book = explode('|', $line);
            if ($book[0] == intval($id)) {
                fclose($file);
                return array(
                    'title' => htmlspecialchars_decode($book[1]),
                    'author' => htmlspecialchars_decode($book[2]),
                    'grade' => $book[3],
                    'isRead' => trim($book[4]) === 'yes'
                );
            }
        }
    }
    fclose($file);
    return null;
}

function find_author_by_id($id): ?array
{
    $file = fopen(AUTHORS_FILE, 'r');
    while (!feof($file)) {
        $line = fgets($file);
        if ($line !== false) {
            $author = explode('|', $line);
            if ($author[0] == intval($id)) {
                fclose($file);
                return array(
                    'firstName' => htmlspecialchars_decode($author[1]),
                    'lastName' => htmlspecialchars_decode($author[2]),
                    'grade' => $author[3],
                );
            }
        }
    }
    fclose($file);
    return null;
}

function update_book($id, $title, $author, $grade, $isRead): void
{
    $file = file(BOOKS_FILE);
    $new_file = array();
    foreach ($file as $line) {
        $book = explode("|", $line);
        if (strval($id) == $book[0]) {
            $book[1] = ($title);
            $book[2] = ($author);
            $book[3] = $grade;
            $book[4] = $isRead;
            $new_book = implode("|", $book) . "\n";
            $new_file[] = $new_book;
        } else {
            $new_file[] = $line;
        }
    }
    $file = fopen(BOOKS_FILE, "w");
    fwrite($file, implode("", $new_file));
    fclose($file);
}

function update_author($id, $firstName, $lastName, $grade): void
{
    $file = file(AUTHORS_FILE);
    $new_file = array();
    foreach ($file as $line) {
        $author = explode("|", $line);
        if (strval($id) == $author[0]) {
            $author[1] = $firstName;
            $author[2] = $lastName;
            $author[3] = $grade;
            $new_author = implode("|", $author) . "\n";
            $new_file[] = $new_author;
        } else {
            $new_file[] = $line;
        }
    }
    $file = fopen(AUTHORS_FILE, "w");
    fwrite($file, implode("", $new_file));
    fclose($file);
}

function delete_item($filename, $id): void
{
    $file = file($filename);
    $new_file = array();
    foreach ($file as $line) {
        $item = explode("|", $line);
        if (strval($id) == $item[0]) {
            $new_file[] = "";
        } else {
            $new_file[] = $line;
        }
    }
    $file = fopen($filename, "w");
    fwrite($file, implode("", $new_file));
    fclose($file);
}

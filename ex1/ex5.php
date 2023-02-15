<?php

require_once 'Post.php';
require_once 'ex3.php';

const DATA_FILE = 'data/posts.txt';

function getAllPosts(): array
{
    $ret = array();
    $lines = file(DATA_FILE);
    foreach (range(0, count($lines) - 1) as $lineNum) {
        $temp = (explode(";", trim($lines[$lineNum], "\ \t\n\r\0\x0B")));

        $post = new Post(urldecode($temp[0]), urldecode($temp[1]));
        $ret[] = $post;
    }
    return $ret;
}

function savePost(Post $post): void
{
    file_put_contents('data/posts.txt', urlencode($post->title) . ";"
        . urlencode($post->text) . "\n", FILE_APPEND);
}

//
//$title = getRandomString(5);
//$text = getRandomString(10) . ".'\n;";
//$post = new Post($title, $text);
//savePost($post);
//var_dump(getAllPosts());
//
//function getRandomString(int $length): string
//{
//    return substr(md5(mt_rand()), 0, $length);
//}
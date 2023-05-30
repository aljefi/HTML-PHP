<?php

require_once __DIR__ . '/MenuItem.php';

printMenu(getMenu());

function getMenu() : array {

    $conn = getConnectionWithData(__DIR__ . '/data.sql');

    $stmt = $conn->prepare('SELECT id, parent_id, name 
                            FROM menu_item ORDER BY id');

    $stmt->execute();

    $menu = [];

    foreach ($stmt as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $parentId = $row['parent_id'];

        var_dump($name);
        $newItem = new MenuItem($id, $name);
        $dict[$id] = $newItem;
        if ($parentId !== null) {
            $dict[$parentId]->addSubItem($newItem);
        }else{
            $menu[] = $newItem;
        }

    }
    return $menu;
}












function printMenu($items, $level = 0) : void {
    $padding = str_repeat(' ', $level * 3);
    foreach ($items as $item) {
        printf("%s%s\n", $padding, $item->name);
        if ($item->subItems) {
            printMenu($item->subItems, $level + 1);
        }
    }
}

function getConnectionWithData($dataFile) : PDO {
    $conn = new PDO('sqlite::memory:');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statements = explode(';', join('', file($dataFile)));

    foreach ($statements as $statement) {
        $conn->prepare($statement)->execute();
    }

    return $conn;
}
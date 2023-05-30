<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';
require_once __DIR__ . '/menu.php';

function menuHasTwoRootItems() {

    $menu = getMenu();

    assertThat(count($menu), is(2));

    assertThat($menu[0]->name, is('Item 1'));
    assertThat($menu[1]->name, is('Item 2'));
}

function firstMenuItemHasCorrectSubStructure() {

    $menu = getMenu();

    assertThat(count($menu[0]->subItems), is(2));

    assertThat($menu[0]->subItems[0]->name, is('Item 1.1'));
    assertThat($menu[0]->subItems[1]->name, is('Item 1.2'));
}

function secondMenuItemHasCorrectSubStructure() {

    $menu = getMenu();

    assertThat(count($menu[1]->subItems), is(1));

    assertThat($menu[1]->subItems[0]->name, is('Item 2.1'));
    assertThat($menu[1]->subItems[0]->subItems[0]->name, is('Item 2.1.1'));
}

stf\runTests(new stf\PointsReporter([1 => 3, 2 => 7, 3 => 10]));

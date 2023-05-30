<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080/ex3/';

setBaseUrl(BASE_URL);

function defaultPageHasCorrectFieldsAndValues() {
    navigateTo(BASE_URL);

    assertPageContainsSelectWithName('list1');
    assertPageContainsSelectWithName('list2');

    assertPageContainsButtonWithName('list1_to_list2');
    assertPageContainsButtonWithName('list2_to_list1');

    $list1options = getOptionValuesOfSelect('list1');
    $list2options = getOptionValuesOfSelect('list2');

    assertThat($list1options, contains(['1', '2', '3', '4']));
    assertThat($list2options, contains(['5', '6']));
}

function canMoveItemsFromList1ToList2() {
    navigateTo(BASE_URL);

    selectOptionWithText('list1', '2');

    clickButton('list1_to_list2');

    $list1options = getOptionValuesOfSelect('list1');
    $list2options = getOptionValuesOfSelect('list2');

    assertThat($list1options, contains(['1', '3', '4']));
    assertThat($list2options, contains(['5', '6', '2']));

    selectOptionWithText('list1', '1');

    clickButton('list1_to_list2');

    $list1options = getOptionValuesOfSelect('list1');
    $list2options = getOptionValuesOfSelect('list2');

    assertThat($list1options, contains(['3', '4']));
    assertThat($list2options, contains(['5', '6', '2', '1']));
}

function canMoveItemsFromList2ToList1() {
    navigateTo(BASE_URL);

    selectOptionWithText('list2', '5');

    clickButton('list2_to_list1');

    $list1options = getOptionValuesOfSelect('list1');
    $list2options = getOptionValuesOfSelect('list2');

    assertThat($list1options, contains(['1', '2', '3', '4', '5']));
    assertThat($list2options, contains(['6']));

    selectOptionWithText('list2', '6');

    clickButton('list2_to_list1');

    $list1options = getOptionValuesOfSelect('list1');
    $list2options = getOptionValuesOfSelect('list2');

    assertThat($list1options, contains(['1', '2', '3', '4', '5', '6']));
    assertThat($list2options, contains([]));
}

stf\runTests(new stf\PointsReporter([2 => 12, 3 => 20]));

<?php

require_once __DIR__ . '/../vendor/php-test-framework/public-api.php';

const BASE_URL = 'http://localhost:8080/';

setBaseUrl(BASE_URL);

function indexToA() {
    navigateTo(BASE_URL);

    clickLinkWithText("a.html");

    assertCurrentUrl(BASE_URL . "a/a.html");
}

function aToE() {
    navigateTo(BASE_URL . 'a/a.html');

    clickLinkWithText("e.html");

    assertCurrentUrl(BASE_URL . "a/b/c/d/e/e.html");
}

function eToD() {
    navigateTo(BASE_URL . 'a/b/c/d/e/e.html');

    clickLinkWithText("d.html");

    assertCurrentUrl(BASE_URL . "a/b/c/d/d.html");
}

function dToB() {
    navigateTo(BASE_URL . 'a/b/c/d/d.html');

    clickLinkWithText("b.html");

    assertCurrentUrl(BASE_URL . "a/b/b.html");
}

function emptyLink() {

    navigateTo(BASE_URL . 'a/b/c/d/e/f/f.html');

    $linkText = "shortest self";

    $href = getHrefFromLinkWithText($linkText);

    clickLinkWithText($linkText);

    assertCurrentUrl(BASE_URL . "a/b/c/d/e/f/f.html");

    assertThat(strlen($href), is(0),
        sprintf("'%s' is not the shortest link possible", $href));
}

function directoryLink() {

    navigateTo(BASE_URL . 'a/b/c/d/e/f/f.html');

    $linkText = "shortest f/index.html";

    $href = getHrefFromLinkWithText($linkText);

    clickLinkWithText($linkText);

    assertCurrentUrl(BASE_URL . "a/b/c/d/e/f/");

    assertThat(strlen($href), is(1),
        sprintf("'%s' is not the shortest link possible", $href));
}

stf\runTests(new stf\PointsReporter([1 => 1, 3 => 3, 6 => 6]));

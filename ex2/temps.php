<?php

require_once '../ex1/ex7.php'; // use existing code
require_once '../ex1/ex8.php';
require_once 'functions.php'; // separate functions from main program

$opts = getopt('c:y:t:', ['command:', 'year:', 'temp:']);

$command = $opts['command'] ?? null;
$year = $opts['year'] ?? null;
$temp = $opts['temp'] ?? null;

if ($command === 'days-under-temp' and $temp != null) {
    // validate that required parameters are provided
    // if not show error and exit
    // calculate result using getDaysUnderTemp()
    // print result
    print getDaysUnderTemp($year, $temp);

} else if ($command === 'days-under-temp-dict') {
    // validate that required parameters are provided
    // if not show error and exit
    // calculate result using getDaysUnderTempDictionary()
    // print result
    printf(dictToString(getDaysUnderTempDictionary($temp)));
} else if ($command === 'avg-winter-temp') {
    print round(getAverageWinterTemp($year), 2);
} else {
    showError('command is missing or is unknown');
    return 0;
}

function showError(string $message): void
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

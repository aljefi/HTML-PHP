<?php


$list1 = isset($_GET['list1_state'])
    ? unserialize($_GET['list1_state'])
    : [1, 2, 3, 4];

$list2 = isset($_GET['list2_state'])
    ? unserialize($_GET['list2_state'])
    : [5, 6];

var_dump($_REQUEST);

if (isset($_GET['list1_to_list2'])) {
    $value = $_GET['list1'];
    $list1 = removeElementByValue($value, $list1);
    $list2[] = $value;
} else if (isset($_GET['list2_to_list1'])) {
    $value = $_GET['list2'];
    $list2 = removeElementByValue($value, $list2);
    $list1[] = $value;
}

$list1state = htmlentities(serialize($list1));
$list2state = htmlentities(serialize($list2));

function removeElementByValue($value, $array): array
{
    $key = array_search($value, $array);
    if ($key === false) {
        return $array;
    }

    unset($array[$key]);
    return array_values($array);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<form>

    <input type="text" name="list1_state" value="<?= $list1state ?>">
    <input type="text" name="list2_state" value="<?= $list2state ?>">

    <select name="list1" multiple>
        <?php foreach ($list1 as $number): ?>
            <option value="<?= $number ?>"><?= $number ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" name="list1_to_list2" value="&gt;&gt;">
    <input type="submit" name="list2_to_list1" value="&lt;&lt;">

    <select name="list2" multiple>
        <?php foreach ($list2 as $number): ?>
            <option value="<?= $number ?>"><?= $number ?></option>
        <?php endforeach; ?>
    </select>

</form>

</body>
</html>

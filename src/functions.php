<?php
function task1()
{
    $xml = simplexml_load_file('src/data.xml');
    echo '<pre>';
    echo 'Purchase Order : ' . $xml->attributes()->PurchaseOrderNumber . '<br>';
    echo 'Order date : ' . $xml->attributes()->OrderDate . '<br>';
    foreach ($xml->Address as $address) {
        echo 'Address type : ' . $address->attributes()->Type . '<br>';
        echo "\t" . 'Name : ' . $address->Name->__toString() . '<br>';
        echo "\t" . 'Street : ' . $address->Street->__toString() . '<br>';
        echo "\t" . 'State : ' . $address->State->__toString() . '<br>';
        echo "\t" . 'Zip : ' . $address->Zip . '<br>';
        echo "\t" . 'Country : ' . $address->Country->__toString() . '<br>';
    }
    echo 'Delivery Notes : ' . $xml->DeliveryNotes->__toString() . '<br>';
    foreach ($xml->Items->Item as $item) {
        echo 'Part Number : ' . $item->attributes()->PartNumber . '<br>';
        echo "\t" . 'Product Name : ' . $item->ProductName->__toString() . '<br>';
        echo "\t" . 'Quantity : ' . $item->Quantity . '<br>';
        echo "\t" . 'US Price : ' . $item->USPrice . '<br>';
        echo "\t" . 'Ship Date : ' . $item->ShipDate . '<br>';
    }
}

function task2()
{
    $arr = json_encode([['Vasya', 'Petya']], JSON_FORCE_OBJECT);
    file_put_contents('output.json', $arr);
    if (file_exists('output.json')) {
        $items = json_decode(file_get_contents('output.json'), true);
        foreach ($items as $key => $value) {
            $rand = rand(0, 1);
            if ($rand) {
                $items[$key][] = 'Vika';
                $items[$key][] = 'Masha';
            }
        }
        $arr2 = json_encode($items, JSON_FORCE_OBJECT);
        file_put_contents('output2.json', $arr2);
    }
    diffArr();
}

function diffArr()
{
    if (file_exists('output.json') && file_exists('output2.json')) {
        $items = json_decode(file_get_contents('output.json'), true);
        $items1 = json_decode(file_get_contents('output2.json'), true);
        $result = implode(',', array_diff($items1[0], $items[0]));
        if ($result) {
            echo 'Данные файлов расходятся на : ' . $result;
        } else {
            echo 'Данные файлов совпадают';
        }

    }
}

function task3()
{
    $arr = [];
    for ($i = 0; $i < 50; $i++) {
        $arr[$i] = rand(1, 100);
    }
    $fp = fopen('file.csv', 'w');
    fputcsv($fp, $arr);
    echo '<br>';
}

function getSum()
{
    $fp = fopen('file.csv', 'r');
    if (!$fp) {
        die ('can\'t open file');
    }
    $array = [];
    while ($str = fgetcsv($fp, 1000 * 1024, ',')) {
        $array = $str;
    }
    $sum = 0;
    foreach ($array as $item) {
        if ($item % 2 === 0) {
            $sum += $item;
        }
    }
    echo 'Сумма четных чисел в файле = ' . $sum;
}

function task4()
{
    $result = file_get_contents('https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json');
    $json = json_decode($result, true);
    echo 'Title is : ' . $json['query']['pages']['15580374']['title'] . '<br>';
    echo 'Page_id is : ' . $json['query']['pages']['15580374']['pageid'] . '<br>';
}
<?php

namespace Differ\Differ;

function genDiff($file1, $file2)
{
    $data1 = file_get_contents($file1, true);
    $data2 = file_get_contents($file2, true);
    $firstFile = json_decode($data1, true);
    $secondFile = json_decode($data2, true);
    var_dump($data1, $data2);
    Exit;
    $data = array_merge($firstFile, $secondFile);
    ksort($data);
    $result = [];
    foreach($data as $key => $value) {
        if(array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
            $result["-" . $key] = $value;
        }
        if(array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] === $secondFile[$key]) {
            $result[" " . $key] = $value;
        }
        if(array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] !== $secondFile[$key]) {
            $result["-" . $key] = $firstFile[$key];
            $result["+" . $key] = $secondFile[$key];
        }
        if(array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile)) {
            $result["+" . $key] = $value;
        }
    }
    return json_encode($result, JSON_PRETTY_PRINT);
}
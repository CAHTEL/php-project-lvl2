<?php

namespace Differ\Differ;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\json;

function genDiff($file1, $file2, $format = 'stylish')
{
    if($format === 'plain') {
    return plain($file1, $file2);
    }
    elseif($format === 'json') {
        return json($file1, $file2);
    }
    else {
        return stylish($file1, $file2);
    }
}
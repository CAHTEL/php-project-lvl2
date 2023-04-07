<?php

namespace Differ\Formatters\Plain;

use function App\Stringify\stringify;

function plain($file1, $file2, $path = "")
{
    if(!is_array($file1) && !is_array($file2)) {
        $data1 = file_get_contents($file1, true);
        $data2 = file_get_contents($file2, true);
        $firstFile = json_decode($data1, true);
        $secondFile = json_decode($data2, true);
        $data = array_merge($firstFile, $secondFile);
        ksort($data);
        $result = "";
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
                $result .= "Property '{$path}{$key}' was removed\n";
            }
            if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] !== $secondFile[$key] && !is_array($value)) {
                $result .= "Property '{$path}{$key}' was updated. From '{$firstFile[$key]}' to '{$secondFile[$key]}'\n";
            }
            if (array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile) && !is_array($value)) {
                $result .= "Property '{$path}{$key}' was added with value: '{$value}'\n";
            }
            if (array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile) && is_array($value)) {
                $result .= "Property '{$path}{$key}' was added with value: [complex value]\n";
            }
            if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] !== $secondFile[$key] && is_array($value)) {
                $plain = plain($firstFile[$key], $secondFile[$key], $path . $key);
                $result .= $plain;
            }
        }
        return $result;
    }
    if (is_array($file1) && is_array($file2)){
        $data = array_merge($file1, $file2);
        ksort($data);
        $result = "";
        foreach ($data as $key => $value) {
        if (array_key_exists($key, $file1) && !array_key_exists($key, $file2)) {
            $result .= "Property '{$path}.{$key}' was removed\n";
        }
        if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] !== $file2[$key] && !is_array($file1[$key]) && !is_array($file2[$key])) {
            $file1[$key] = stringify($file1[$key]);
            $file2[$key] = stringify($file2[$key]);
            $result .= "Property '{$path}.{$key}' was updated. From '{$file1[$key]}' to '{$file2[$key]}'\n";
        }
        if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] !== $file2[$key] && is_array($file1[$key]) && !is_array($file2[$key])) {
            $result .= "Property '{$path}.{$key}' was updated. From [complex value] to '{$file2[$key]}'\n";
        }
        if (array_key_exists($key, $file2) && !array_key_exists($key, $file1) && !is_array($value)) {
            $value = stringify($value);
            $result .= "Property '{$path}.{$key}' was added with value: '{$value}'\n";
        }
        if (array_key_exists($key, $file2) && !array_key_exists($key, $file1) && is_array($value)) {
            $result .= "Property '{$path}.{$key}' was added with value: [complex value]\n";
        }
        if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] !== $file2[$key] && is_array($value)) {
            $result .= plain($file1[$key], $file2[$key], $path .= "." . $key);
        }
            }
           return $result;
    }
}

<?php

namespace Differ\Formatters\Json;


function json($file1, $file2) {
    if(!is_array($file1) && !is_array($file2)) {
        $data1 = file_get_contents($file1, true);
        $data2 = file_get_contents($file2, true);
        $firstFile = json_decode($data1, true);
        $secondFile = json_decode($data2, true);
        $data = array_merge($firstFile, $secondFile);
        ksort($data);
        $result = [];
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
                $result["-" . $key] = $value;
            }
            if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] === $secondFile[$key]) {
                $result[" " . $key] = $value;
            }
            if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] !== $secondFile[$key] && !is_array($value)) {
                $result["-" . $key] = $firstFile[$key];
                $result["+" . $key] = $secondFile[$key];
            }
            if (array_key_exists($key, $secondFile) && !array_key_exists($key, $firstFile)) {
                $result["+" . $key] = $value;
            }
            if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile) && $firstFile[$key] !== $secondFile[$key] && is_array($value)) {
                $result[" " . $key] = json($firstFile[$key], $secondFile[$key]);
            }
            }
        
        return json_encode($result); }
        
        if (is_array($file1) && is_array($file2)) {
            $data = array_merge($file1, $file2);
            ksort($data);
            $result = [];
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $file1) && !array_key_exists($key, $file2)) {
                    $result["-" . $key] = $value;
                }
                if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] === $file2[$key]) {
                    $result[" " . $key] = $value;
                }
                if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] !== $file2[$key] && !is_array($value)) {
                    $result["-" . $key] = $file1[$key];
                    $result["+" . $key] = $file2[$key];
                }
                if (array_key_exists($key, $file2) && !array_key_exists($key, $file1)) {
                    $result["+" . $key] = $value;
                }
                if (array_key_exists($key, $file1) && array_key_exists($key, $file2) && $file1[$key] !== $file2[$key] && is_array($value)) {
                    $result[" " . $key] = json($file1[$key], $file2[$key]);
                }
                }
            
            return $result; 
        }
    }
<?php

namespace Tests\GendiffTest;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    public function testGendiff(): void
    {
        $file1Json = __DIR__ . "/fixtures/file1.json";
        $file2Json = __DIR__ . "/fixtures/file2.json";
        $result1 = file_get_contents(__DIR__ . "/fixtures/result1.json", true);
        $this->assertEquals($result1, genDiff($file1Json, $file2Json));
        $file1Yml = __DIR__ . "/fixtures/file1.yml";
        $file2Yml = __DIR__ . "/fixtures/file2.yml";
        $this->assertEquals($result1, gendiff($file1Yml, $file2Yml));
        $file3Json = __DIR__ . "/fixtures/file3.json";
        $file4Json = __DIR__ . "/fixtures/file4.json";
        $result2 = file_get_contents(__DIR__ . "/fixtures/result2.json", true);
        $this->assertEquals($result2, gendiff($file3Json, $file4Json));
    }
}
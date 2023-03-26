<?php

namespace Tests\GendiffTest;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GendiffTest extends TestCase
{
    public function testGendiff(): void
    {
        $file1 = __DIR__ . "/fixtures/file1.json";
        $file2 = __DIR__ . "/fixtures/file2.json";
        $result = file_get_contents(__DIR__ . "/fixtures/result.json", true);
        $this->assertEquals($result, genDiff($file1, $file2));
    }
}
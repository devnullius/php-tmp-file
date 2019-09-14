<?php
// Some travis environments use phpunit > 6
use PHPUnit\Framework\TestCase;

$newClass = TestCase::class;
$oldClass = '\PHPUnit_Framework_TestCase';
if (!class_exists($newClass) && class_exists($oldClass)) {
    class_alias($oldClass, $newClass);
}

require __DIR__ . '/../vendor/autoload.php';


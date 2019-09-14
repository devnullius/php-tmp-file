<?php

use devnullius\tmp\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testCanCreateFile(): void
    {
        $content = 'test content';
        $tmp = new File($content);
        $fileName = $tmp->getFileName();
        
        $this->assertFileExists($fileName);
        $readContent = file_get_contents($fileName);
        $this->assertEquals($content, $readContent);
        unset($tmp);
        $this->assertFileNotExists($fileName);
    }
    
    public function testCanCreateFileWithSuffix(): void
    {
        $content = 'test content';
        $tmp = new File($content, null, 'test_');
        $fileName = $tmp->getFileName();
        $baseName = basename($fileName);
        
        $this->assertEquals('test_', substr($baseName, 0, 5));
    }
    
    public function testCanCreateFileWithPrefix(): void
    {
        $content = 'test content';
        $tmp = new File($content, '.html');
        $fileName = $tmp->getFileName();
        
        $this->assertEquals('.html', substr($fileName, -5));
    }
    
    public function testCanCreateFileInDirectory(): void
    {
        $dir = __DIR__ . '/tmp';
        @mkdir($dir);
        $content = 'test content';
        $tmp = new File($content, null, null, $dir);
        $fileName = $tmp->getFileName();
        $this->assertEquals($dir, dirname($fileName));
        
        unset($tmp);
        @rmdir($dir);
    }
    
    public function testCanSaveFileAs(): void
    {
        $out = $this->getOut();
        $content = 'test content';
        $tmp = new File($content);
        $fileName = $tmp->getFileName();
        
        $this->assertFileExists($fileName);
        $this->assertTrue($tmp->saveAs($out));
        $this->assertFileExists($out);
        $readContent = file_get_contents($out);
        $this->assertEquals($content, $readContent);
        unset($tmp);
        $this->assertFileNotExists($fileName);
        $this->assertFileExists($out);
        unlink($out);
    }
    
    public function testCanKeepTempFile(): void
    {
        $out = $this->getOut();
        $content = 'test content';
        $tmp = new File($content);
        $tmp->delete = false;
        $fileName = $tmp->getFileName();
        
        $this->assertFileExists($fileName);
        $this->assertTrue($tmp->saveAs($out));
        $this->assertFileExists($out);
        unset($tmp);
        $this->assertFileExists($fileName);
        $this->assertFileExists($out);
        unlink($out);
    }
    
    public function testCanCastToFileName(): void
    {
        $content = 'test content';
        $tmp = new File($content);
        $fileName = $tmp->getFileName();
        
        $this->assertEquals($fileName, (string)$tmp);
    }
    
    public function testCanCallableWork(): void
    {
        $content = 'test content';
        $tmp = new File($content);
        $fileName = $tmp->getFileName();
        
        $this->assertEquals($fileName, (string)$tmp);
        $testFirst = 1;
        $testSecond = 1;
        $test_FileName = '';
        $testFileName = '';
        $tmp->setResponseMethod(static function ($_filename, $filename) use (&$testFirst, &$testSecond, &$test_FileName, &$testFileName) {
            ++$testFirst;
            $testSecond += 2;
            $test_FileName = $_filename;
            $testFileName = $filename;
        });
        $filename = 'greatFile.txt';
        $tmp->send($filename);
        $this->assertEquals($testFirst, 2);
        $this->assertEquals($testSecond, 3);
        $this->assertEquals($test_FileName, $fileName);
        $this->assertEquals($testFileName, $filename);
    }
    
    private function getOut(): string
    {
        return __DIR__ . '/test.txt';
    }
}



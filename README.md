php-tmp-file
===========

[![pipeline status](https://gitlab.com/aram.ds/php-tmp-file/badges/master/pipeline.svg)](https://gitlab.com/aram.ds/php-tmp-file/commits/master)
[![coverage report](https://gitlab.com/aram.ds/php-tmp-file/badges/master/coverage.svg)](https://gitlab.com/aram.ds/php-tmp-file/commits/master)


A convenience class for temporary files.

## Features

 * Create temporary file with arbitrary content
 * Delete file after use (can be disabled)
 * Send file to client, either inline or with save dialog
 * Save file locally
 * Inject callback with custom file sender

## Examples

```php
<?php
use devnullius\tmp\File;

$file = new File('some content', '.html');

// send to client for download
$file->send('home.html');

// save to disk
$file->saveAs('/dir/test.html');

// Access file name and directory
echo $file->getFileName();
echo $file->getTempDir();
```

If you want to keep the temporary file, e.g. for debugging, you can set the `$delete` property to false:

```php
<?php
use devnullius\tmp\File;

$file = new File('some content', '.html');
$file->delete = false;
```
If you want to use other way to send files you can give callback as in example (Here is Yii2 response sendFile)

```php
<?php
use devnullius\tmp\File;

$file = new File('some content', '.html');

$file->setResponseMethod(static function ($_filename, $filename) {
    \Yii::$app->response->sendFile($_filename, $filename);
});
$fileName = 'greatFileName.txt';
// and if there is set any response method it's going to be executed
$file->send($fileName);
```




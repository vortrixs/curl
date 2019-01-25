<?php

require __DIR__ . '/../Curl.php';

use Vortrixs\Curl\Curl;

$curl = new Curl('http://google.com');

file_put_contents('./test.txt', 'This is a test file');

$file = $curl->createCurlFile('test.txt', 'text/*', 'test_file');

if (! ($file instanceof \CURLFile))
{
	echo 'CURLFile corrupted';
	var_dump($file, file_get_contents('./test.txt'));
	unlink('./test.txt');
	exit(1);
}

$curl->options([CURLOPT_POST => true, CURLOPT_POSTFIELDS => ['file' => $file]]);

var_dump($curl->handle());

$curl->close();

unlink('./test.txt');

exit(0);

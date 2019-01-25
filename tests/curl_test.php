<?php

require __DIR__ . '../Curl.php';

use Vortrixs\Curl\Curl;

$exit = 0;

$curl = new Curl('http://google.com');

var_dump($curl->version());

$curl->options([CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true]);

$result = $curl->execute();

if (false === $result)
{
	var_dump($curl->error(), $curl->errno());
	$exit = 1;
}

var_dump($curl->info(CURLINFO_HTTP_CODE));

$curl->close();

exit($exit);

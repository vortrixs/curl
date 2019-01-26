<?php

require __DIR__ . '/../Curl.php';

use Vortrixs\Curl\Curl;

try
{
	$curl = new Curl('http://google.com');

	$curl->options([CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true]);

	$result = $curl->execute();

	var_dump($curl->info(CURLINFO_HTTP_CODE));

	if (false === $result || 200 !== $curl->info(CURLINFO_HTTP_CODE))
	{
		var_dump($curl->error(), $curl->errno());
		$curl->close();
		exit(1);
	}

	var_dump($result);

	$curl->close();
	exit(0);
}
catch(\Throwable $t)
{
	echo $t;
	exit(1);
}

<?php

require __DIR__ . '/../Curl.php';

use Vortrixs\Curl\Curl;

try
{
	$exit = 0;

	$curl = new Curl('https://transfer.sh/vortris-curl-test.txt');

	file_put_contents('./test.txt', 'This is a test file');

	$file = $curl->createCurlFile('test.txt', 'text/*', 'test_file');

	if ( ! ($file instanceof \CURLFile))
	{
		echo 'CURLFile not created.';
		var_dump($file, file_get_contents('./test.txt'));
		$curl->close();
		exit(1);
	}

	$curl->options([CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => ['file' => $file]]);

	$result = $curl->execute();

	var_dump($curl->info(CURLINFO_HTTP_CODE));

	if (false === $result || 200 !== $curl->info(CURLINFO_HTTP_CODE))
	{
		var_dump($curl->error(), $curl->errno());
		$exit = 1;
	}

	var_dump($result);

	$curl->close();
}
catch(\Throwable $t)
{
	echo $t;
	$exit = 1;
}

exit($exit);




try
{
	



	

	$curl->execute();



	$curl->close();

	unlink('./test.txt');

	exit(0);
}
catch (\Throwable $t)
{
	echo $t;
	exit(1);
}

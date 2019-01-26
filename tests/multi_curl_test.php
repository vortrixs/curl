<?php

require __DIR__ . '/../Curl.php';
require __DIR__ . '/../MultiCurl.php';

use Vortrixs\Curl\Curl;
use Vortrixs\Curl\MultiCurl;

try
{
	$curl1 = new Curl('https://www.google.com/basepages/producttype/taxonomy.en-US.txt');
	$curl1->options([CURLOPT_RETURNTRANSFER => true]);

	$curl2 = new Curl('https://www.google.com/basepages/producttype/taxonomy.da-DK.txt');
	$curl2->options([CURLOPT_RETURNTRANSFER => true]);

	$curl3 = new Curl('https://www.google.com/basepages/producttype/taxonomy.ja-JP.txt');
	$curl3->options([CURLOPT_RETURNTRANSFER => true]);
	
	$curl4 = new Curl('https://www.google.com/basepages/producttype/taxonomy.fr-FR.txt');
	$curl4->options([CURLOPT_RETURNTRANSFER => true]);

	$multi = new MultiCurl($curl1, $curl2, $curl3, $curl4);

	$result = $multi->execute();

	if ($multi->errno() > 0)
	{
		echo "cURL Error {$multi->errno()}: {$multi->strerror()}";
		$multi->close();
		exit(1);
	}

	foreach ($result as $content)
		echo substr($content, 0, 100) . str_repeat(PHP_EOL, 2);

	$multi->close();
	exit(0);
}
catch(\Throwable $t)
{
	echo $t;
	exit(1);
}

# Curl Wrappers for OOP

[![CircleCI](https://circleci.com/gh/vortrixs/curl/tree/master.svg?style=svg)](https://circleci.com/gh/vortrixs/curl/tree/master)

# Requirements
* PHP 7.2 or newer

# Usage

## cURL

```php
use Vortrixs\Curl\Curl;

$curl = new Curl('http://google.com');

$curl->options([CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true]);

$result = $curl->execute();

if (false === $result || 200 !== $curl->info(CURLINFO_HTTP_CODE))
{
	var_dump($curl->error(), $curl->errno());
	$curl->close();
	exit(1);
}

var_dump($result);

$curl->close();
```

## Multi cURL

```php
use Vortrixs\Curl\Curl;
use Vortrixs\Curl\MultiCurl;

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
	var_dump($content);

$multi->close();
```

## Shared cURL
_Under construction_

<?php

namespace Vortrixs\Curl;

class ShareCurl {
	private $handle;

	private $handles;

	public function __construct (Curl ...$handles)
	{
		$this->handle  = curl_share_init();
		$this->handles = $handles;

		foreach ($handles as $curl)
			$curl->options([CURLOPT_SHARE => $this->handle]);
	}

	public function execute () : Generator
	{
		foreach ($this->handles as $curl)
			yield $curl->execute();
	}

	public function close () : void
	{
		curl_share_close($this->handle);

		foreach ($this->handles as $curl)
			$curl->close();
	}

	public function errno () : int
	{
		return curl_share_errno($this->handle);
	}

	public function strerror(?int $errno = null) : ?string
	{
		return curl_share_strerror($errno ?? $this->errno());
	}

	public function options (array $options)
	{
		foreach ($options as $key => $value)
			curl_share_setopt($this->handle, $key, $value);
	}
}

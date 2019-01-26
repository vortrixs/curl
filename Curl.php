<?php

namespace Vortrixs\Curl;

class Curl {
	/**
	 * @var resource
	 */
	private $handle;

	public function __construct ($handle)
	{
		if (is_resource($handle))
			$this->handle = $handle;
		elseif (is_string($handle))
			$this->handle = curl_init($handle);

		if (false === $this->handle)
			throw new \RuntimeException('Could not set cURL handle.');
	}

	public function handle ()
	{
		return $this->handle;
	}

	public function options (array $options) : void
	{
		if (!empty($options) && false === curl_setopt_array($this->handle, $options))
			throw new \RuntimeException('Could not set cURL options.');
	}

	public function close () : void
	{
		curl_close($this->handle);
	}

	public function copy () : Curl
	{
		return new Curl(curl_copy_handle($this->handle));
	}

	public function errno () : int
	{
		return curl_errno($this->handle);
	}

	public function strerror (?int $errno = null) : ?string
	{
		return curl_strerror($errno ?? $this->errno());
	}

	public function error () : string
	{
		return curl_error($this->handle);
	}

	public function escape (string $string) : string
	{
		return curl_escape($this->handle, $str);
	}

	public function unescape (string $string) : string
	{
		return curl_unescape($this->handle, $str);
	}

	public function execute ()
	{
		return curl_exec($this->handle);
	}

	public function createCurlFile (string $filename, string $mimetype, string $postname) : \CURLFile
	{
		return new \CURLFile($filename, $mimetype, $postname);
	}

	public function info (?int $option = null)
	{
		return curl_getinfo($this->handle, $option);
	}

	public function reset () : void
	{
		curl_reset($this->handle);
	}

	public function version (int $age = CURLVERSION_NOW) : array
	{
		return curl_version($age);
	}
}

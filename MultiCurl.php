<?php

namespace Vortrixs\Curl;

class MultiCurl {
	/**
	 * @var resource
	 */
	private $handle;

	/**
	 * @var Curl[]
	 */
	private $handles;

	public function __construct (Curl ...$handles)
	{
		$this->handle  = curl_multi_init();
		$this->handles = $handles;

		foreach ($handles as $curl)
			curl_multi_add_handle($this->handle, $curl->handle());
	}

	public function close() : void
	{
		foreach ($this->handles as $curl)
		{
			curl_multi_remove_handle($this->handle, $curl->handle());

			$curl->close();
		}

		curl_multi_close($this->handle);
	}

	public function add (Curl $curl) : int
	{
		return curl_multi_add_handle($this->handle, $curl->handle());
	}

	public function remove (Curl $curl) : int
	{
		$ret = curl_multi_remove_handle($this->handle, $curl->handle());

		$curl->close();

		return $ret;
	}

	public function errno () : int
	{
		return curl_multi_errno($this->handle);
	}

	public function strerror (?int $errno = null) : ?string
	{
		return curl_multi_strerror($errno ?? $this->errno());
	}

	public function execute () : int
	{
		$active = null;

		do {
		    $mrc = curl_multi_exec($this->handle, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);

		while ($active && $mrc == CURLM_OK) {
		    if (curl_multi_select($this->handle) != -1) {
		        do {
		            $mrc = curl_multi_exec($this->handle, $active);
		        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
		    }
		}

		return $this->content();
    }

    private function content () : \Generator
    {
    	foreach ($this->handles as $curl)
    		yield curl_multi_getcontent($curl->handle());
    }

    public function info () : array
    {
    	return curl_multi_info_read($this->handle);
    }

    public function options (array $options) : \Generator
    {
    	foreach ($options as $key => $value)
    		yield curl_multi_setopt($this->handle, $key, $value);
    }
}

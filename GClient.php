<?php
require "vendor/autoload.php";
use \GuzzleHttp\Client;

class GClient {
	private $_client, $_result;
	
	public function __construct() {
		$this->_client = new Client([
			"base_uri" => "https://cse.google.com/cse/element/"
		]);
	}
	final public function result() {
		return $this->_result;
	}
	final public function search($mulai = 0, $jumlah = 5, $query = "Cara tidur") {
		$token = file_get_contents("https://cse.google.com/cse.js?cx=partner-pub-2698861478625135:3033704849");
		@preg_match_all('("cse_token": "(.*?)")i', $token, $API);

		$resp = $this->_client->request("GET", "v1", [
		"headers"  => [
				"User-Agent"  => "Mozilla/70.0.1 (Linux; Android 8.1.0; M5) AppleWebKit/604.1 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Version/13.0 Mobile/15E148 Safari/604.1"
			],
		"query" => [
			"hl" => "en",
			"cx" => "partner-pub-2698861478625135:3033704849",
			"safe" => "off",
			"cse_tok" => $API[1][0],
			"start" => $mulai,
			"callback" => "x",
			"num" => $jumlah,
			"q" => $query
			]
		]);
		$this->_result = $resp->getBody()->getContents();
	}
}

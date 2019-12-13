<?php
require_once "vendor/autoload.php";

class GClient {
	private $_Client, $_Result;
	
	public function __construct() {
		$this->_Client = new GuzzleHttp\Client([
			"base_uri" => "https://cse.google.com/cse/element/"
		]);
	}
	public function getContents() {
		return $this->_Result;
	}
	public function gSearch($Jumlah = null, $Dork) {
		$Token = file_get_contents("https://cse.google.com/cse.js?cx=partner-pub-2698861478625135:3033704849");
		@preg_match_all('("cse_token": "(.*?)")i', $Token, $API);
		$Resp = $this->_Client->request("GET", "v1", [
		"headers"  => [
				"User-Agent"  => "Mozilla/70.0.1 (Linux; Android 8.1.0; M5) AppleWebKit/604.1 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Version/13.0 Mobile/15E148 Safari/604.1"
			],
		"query" => [
			"hl"					 => "en",
			"cx"					 => "partner-pub-2698861478625135:3033704849",
			"safe"			 => "off",
			"cse_tok"	 => $API[1][0],
			"start"			 => rand(1, 100),
			"callback" => "x",
			"num"				 => $Jumlah,
			"q"					 => $Dork
			]
		]);
		$this->_Result = $Resp->getBody()->getContents();
	}
}
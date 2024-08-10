<?php


class MainClass
{
	private $user,
	$pass,
	$app,
	$key;
	private $link = 'http://api.drncloud.com/out/ext_api/';
	public function __construct($user, $pass, $app, $key) {
		$this->user = $user;
		$this->pass = $pass;
		$this->app = $app;
		$this->key = $key;
		return true;
	}
	public function returnLinkWithMethodAndMainData($method) {
		return $this->link . $method . '?name=' . $this->user . '&pwd=' . $this->pass . '&ApiKey=' . $this->key . '&pid=' . $this->app;
	}
	// get number
	public function getNumber($countryCode, $boackList = 0 /*0=yours,1=all*/) {
		$get = json_decode(file_get_contents($this->returnLinkWithMethodAndMainData("getMobile") . "&cuy=$countryCode&num=1&noblack=$boackList&serial=2"));
		if ($get->code == 200) {
			$num = $get->data;
			if (empty($num))
				return array(
					'Error' => 'empty number'
				);
			else
				return array(
					'Error' => null,
					'num' => $num,
					'id' => $this->app
			);
		} else {
			return array(
				'Error' => $get->msg
			);
		}
	}
	public function getCode($num, $id) {
		$get = json_decode(file_get_contents($this->returnLinkWithMethodAndMainData("getMsg") . "&pn=$num&serial=2"));
		if ($get->code == 200) {
			$code = $get->data;
			if (empty($code))
				return array(
					'Error' => 'empty code'
				);
			else
				return array(
					'Error' => null,
					'code' => $code
				);
		} else {
			return array(
				'Error' => $get->msg
			);
		}
	}
	public function banNum($num, $id) {
		$get = json_decode(file_get_contents($this->returnLinkWithMethodAndMainData("addBlack") . "&pn=$num"));
		return $get->msg;
	}
}
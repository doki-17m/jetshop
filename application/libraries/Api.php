<?php

class Api {

	private $APIKEY = "d3d8d3e10f98e869dec3e5242cf9b597";

	private $POST = "POST";

	private $GET = "GET";

	private $url_province = "https://api.rajaongkir.com/starter/province";

	private $url_city = "https://api.rajaongkir.com/starter/city";

	private $url_cost = "https://api.rajaongkir.com/starter/cost";
	
	public function check_cost() {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->url_cost,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $this->POST,
			CURLOPT_POSTFIELDS => "origin=501&destination=114&weight=1700&courier=jne",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: $this->APIKEY"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
	}

	public function check_city($province) {
		$curl = curl_init();
		if (!empty($province)) {
			$url = $this->url_city.'?province='.$province;
		} else {
			$url = $this->url_city;
		}
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $this->GET,
			CURLOPT_HTTPHEADER => array(
				"key: $this->APIKEY"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
	}

	public function check_province() {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->url_province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $this->GET,
			CURLOPT_HTTPHEADER => array(
				"key: $this->APIKEY"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			return json_decode($response);
		}
	}
}

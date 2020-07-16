<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guzzle{
	
	protected $client;
	protected $cookieJar;
	protected $api_hris_key;
	protected $api_hris;
	protected $api_foodcoupon;
	protected $api_mail;


	function __construct(){
		$this->client 			= new \GuzzleHttp\Client();
		$this->cookieJar 		= new \GuzzleHttp\Cookie\CookieJar();
		$this->api_hris_key 	= 'hris-keys';
		$this->api_hris 		= 'http://192.168.100.100/apps-api/hris/';
		$this->api_foodcoupon 	= 'http://192.168.100.100/apps-api/fc/';
		$this->api_mail 		= 'https://idocs-mail-api.metrotv.co.id/v1/';
		
	}
	
	function search_HRIS($uri, $params = false){
		$post_data = ['userkeys' => $this->api_hris_key];
		if ($params) $post_data += $params;
		try{
			$response = $this->client->request('POST', 'http://192.168.100.100/apps-api/search/'.$uri, [
				'form_params' => $post_data,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		}
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}
	}
	
	function guzzle_HRIS($uri, $params = false){
		$post_data = ['userkeys' => $this->api_hris_key];
		if ($params) $post_data += $params;
		try{
			$response = $this->client->request('POST', $this->api_hris.$uri, [
				'form_params' => $post_data,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		} 
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}
	}
	
	function guzzle_FC($uri, $params = false){
		$post_data = ['userkeys' => $this->api_hris_key];
		if ($params) $post_data += $params;
		try{
			$response = $this->client->request('POST', $this->api_foodcoupon.$uri, [
				'form_params' => $post_data,
				'cookies' => $this->cookieJar
			]);
			return $response->getBody()->getContents();
		} 
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}
	}
	
	function guzzle_mail($uri, $method, $params = false){
		try{
			if ($params){
				$response = $this->client->request($method , $this->api_mail.$uri, [
					'form_params' => $params,
					'cookies' => $this->cookieJar
				]);
			}
			else{
				$response = $this->client->request($method , $this->api_mail.$uri);
			}
			return $response->getBody()->getContents();
		}
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}
	}
	
	function guzzle_mail_json($uri, $method, $params = false){
		try{
			$response = $this->client->request($method , $this->api_mail.$uri, [
				'json' => $params
			]);
			return $response->getBody()->getContents();
		}
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}
	}

	function guzzle_get_invoices($uri, $PeriodMonth, $PeriodYear, $params=[]){
		$PeriodMonth		= ( strlen($PeriodMonth) == 1 ? '0'.$PeriodMonth : $PeriodMonth );
		$PeriodYear			= $PeriodYear;
		$dateNow			= $PeriodYear.$PeriodMonth;
		$token				= 'EE5CE52C7849534B1C91950FD5D7F8EB121403AA';
		$url 				= 'https://bms.metrotv.co.id/api';
		$params['token'] 	= $token;
		$params['period']	= $dateNow;

		if (isset($order_no)) {
			$params['order_no']	= $order_no;
		}

		if (isset($invoice_no)) {
			$params['invoice_no'] = $invoice_no;
		}

		try{
			$response = $this->client->request('GET', sprintf('%s/%s?%s', $url, $uri, http_build_query($params)));
			return $response->getBody()->getContents();
		} 
		catch (\GuzzleHttp\Exception\BadResponseException $e){
			$response = $e->getResponse();
			$statusCode = $response->getStatusCode();
			// $responseBodyAsString = $response->getBody()->getContents();
			// return $responseBodyAsString;
			return json_encode([
				'type'			=> 'error',
				'status'		=> 'error',
				'status_code'	=> $statusCode,
				'message'		=> 'error'
			]);
		}

	}
	

	/**
	 *  
	 *   ===================
	 *	----- EXAMPLE -----
	 *	===================
	 *	In your controller :
	 *	--------------------
	 *	$this->load->library('guzzle');
	 *	================================================================================================
	 *	*** GET EMPLOYEE DATA ***
	 *	$data = $this->guzzle->guzzle_HRIS('employee/get);		//return all employee
	 *	
	 *	$data = $this->guzzle->guzzle_HRIS('employee/get', [	//return specific employee
	 *		'nip' 			=> string 							//post data
	 *	]);
	 * 
	 * 
	 * 
	 */
} 
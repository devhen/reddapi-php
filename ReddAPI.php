<?php

/**
 * reddapi-php
 * PHP wrapper for ReddAPI, the Reddcoin API
 * 
 * @author Devin Henderson <code@devhen.net>
 */
 
class ReddAPI
{

	// Private variables
	private $api_key;
	
	/**
	 * Construct the object
	 * @param  string  $key  API key
	 */
	function __construct($key='') {
		
		$this->api_key = $key;
		
	}
	
	/**
	 * Make a request
	 * @param   string  $method  POST or GET
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request($method, $cmd, $args=array()) {
		
		$args = array('APIKey' => $this->api_key) + $args;
		
		if($method == 'POST') {
			return $this->_request_post($cmd, json_encode($args));
		} else if($method == 'GET') {
			return $this->_request_get($cmd, $args);
		}
		
	}
	
	/**
	 * Make the request using POST
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request_post($cmd, $args) {
		
		$url =  'https://api.reddapi.com/v1/json/'.$cmd;
		
		// Initiate curl and set headers/options
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($args))
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
		
		// Execute the curl request
		$result = curl_exec($curl);
		curl_close($curl);
		
		if($result) {
			
			$result = json_decode($result);
			if(isset($result->ErrorMessage)) {
				error_log('ReddAPI Error: ' . $result->ErrorMessage);
			}
			return $result;
			
		} else {
			return false;
		}
	}
	
	/**
	 * Make the request using GET
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request_get($cmd, $args) {
		
		$url =  'https://api.reddapi.com/v1/json/'.$cmd.'/'.implode('/', $args);
		
		// Initiate curl and set headers/options
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// Execute the curl request
		$result = curl_exec($curl);
		curl_close($curl);
		
		if($result) {
			
			$result = json_decode($result);
			if(isset($result->ErrorMessage)) {
				error_log('ReddAPI Error: ' . $result->ErrorMessage);
			}
			return $result;
			
		} else {
			return false;
		}
	}
	
	/**
	 * Set the API key
	 * @param   string  $key  The API key
	 * @return  boolean
	 */
	public function set_key($key) {
		
		$this->api_key = $key;
		
	}
	
	/**
	 * Get the API key
	 * @param  void
	 */
	public function get_key() {
	
		return $this->api_key;
		
	}
	
	/**
	 * Gets user list
	 * @param   void
	 * @return  json
	 */
	public function get_user_list() {
		
		return $this->_request('GET', 'GetUserList');
		
	}
	
	/**
	 * Gets info for a user
	 * @param   string  $username  The username to get info for
	 * @return  json
	 */
	public function get_user_info($username) {
		
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('GET', 'GetUserInfo', $args);
		
	}
	
	/**
	 * Gets balance for a user
	 * @param   string  $username  The username to get balance for
	 * @return  json
	 */
	public function get_user_balance($username) {
		
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('GET', 'GetUserBalance', $args);
		
	}
	
	/**
	 * Creates a new user and returns info for that user
	 * @param   string  $username  The username to create
	 * @return  json
	 */
	public function create_new_user($username) {
		
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('POST', 'CreateNewUser', $args);
		
	}
	
	/**
	 * Sends to a Reddcoin address
	 * @param   string  $username  The username to send from
	 * @param   float   $amount    The amount to send
	 * @param   string  $address   The Reddcoin address to send to
	 * @return  json
	 */
	public function send_to_address($username, $amount, $address) {
		
		$args = array(
			'UsernameFrom' => $username,
			'AddressTo' => $address,
			'Amount' => $amount
		);
		
		return $this->_request('POST', 'SendToAddress', $args);
		
	}
	
	/**
	 * Moves coins from one user to another
	 * @param   string  $username_from  The username to move from
	 * @param   string  $username_to    The username to move to
	 * @param   float   $amount         The amount to move
	 * @return  json
	 */
	public function move_to_user($username_from, $username_to, $amount) {
		
		$args = array(
			'UsernameFrom' => $username_from,
			'UsernameTo' => $username_to,
			'Amount' => $amount
		);
		
		return $this->_request('POST', 'MoveToUser', $args);
		
	}

}
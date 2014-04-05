<?php

/**
 * reddapi-php
 * ReddAPI.class.php
 * PHP wrapper for ReddAPI, the Reddcoin API
 * 
 * @author Devin Henderson <code@devhen.net>
 */
 
class ReddAPI
{

	// +-----------------------------------------------------------------------+
	// | Private variables                                                     |
	// +-----------------------------------------------------------------------+
	
	private $key_get;
	private $key_post;
	
	// +-----------------------------------------------------------------------+
	// | Private methods                                                       |
	// +-----------------------------------------------------------------------+
	
	/**
	 * Construct the object
	 * @param  string  $key_get   API key for GET
	 * @param  string  $key_post  API key for POST
	 */
	function __construct($key_get='', $key_post='')
	{
		$this->key_get = $key_get;
		$this->key_post = $key_post;
	}
	
	/**
	 * Private function for making a request
	 * @param   string  $method  POST or GET
	 * @param   string  $cmd     Operation
	 * @param   array   $args    Arguments
	 * @return  json
	 */
	private function _request($method, $cmd, $args=array())
	{
		if($method == 'POST') {
			return $this->_request_post($cmd, $args);
		} else if($method == 'GET') {
			return $this->_request_get($cmd, $args);
		}
	}
	
	/**
	 * Private function for making a request using POST
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request_post($cmd, $args)
	{
		$args = array('APIKey' => $this->key_post) + $args;
		
		$url = 'https://api.reddapi.com/v1/json/'.$cmd;
		
		// Initiate curl and set headers/options
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: '.strlen(json_encode($args)))
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args));
		
		// Execute the curl request
		$result = curl_exec($curl);
		curl_close($curl);
		
		if($result) {
			$result = json_decode($result);
			// Log any errors
			if(isset($result->ErrorMessage)) {
				error_log('ReddAPI Error: '.$result->ErrorMessage);
			}
			return $result;
		} else {
			return false;
		}
	}
	
	/**
	 * Private function for making a request using GET
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request_get($cmd, $args)
	{
		$args = array('APIKey' => $this->key_get) + $args;
		
		$url = 'https://api.reddapi.com/v1/json/'.$cmd.'/'.implode('/', $args);
		
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
			// Log any errors
			if(isset($result->ErrorMessage)) {
				error_log('ReddAPI Error: '.$result->ErrorMessage);
			}
			return $result;
		} else {
			return false;
		}
	}
	
	// +-----------------------------------------------------------------------+
	// | Public methods for API key get/set                                    |
	// +-----------------------------------------------------------------------+
	
	/**
	 * Sets the API key for GET requests
	 * @param  string  $key  The API key
	 */
	public function set_key_get($key)
	{
		$this->key_get = $key;
	}
	
	/**
	 * Sets the API key for POST requests
	 * @param  string  $key  The API key
	 */
	public function set_key_post($key)
	{
		$this->key_post = $key;
	}
	
	/**
	 * Gets the API key for GET requests
	 * @param  void
	 * @return string
	 */
	public function get_key_get()
	{
		return $this->key_get;
	}
	
	/**
	 * Gets the API key for POST requests
	 * @param  void
	 * @return string
	 */
	public function get_key_post()
	{
		return $this->key_post;
	}
	
	// +-----------------------------------------------------------------------+
	// | Public GET methods                                                    |
	// +-----------------------------------------------------------------------+
	
	/**
	 * Gets a list of all users
	 * @param   void
	 * @return  array
	 */
	public function get_user_list()
	{
		return $this->_request('GET', 'GetUserList');
	}
	
	/**
	 * Gets info for a user
	 * @param   string  $username  The username to get info for
	 * @return  json
	 */
	public function get_user_info($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('GET', 'GetUserInfo', $args);
	}
	
	/**
	 * Gets balance for a user
	 * @param   string  $username  The username to get balance for
	 * @return  float
	 */
	public function get_user_balance($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('GET', 'GetUserBalance', $args);
	}
	
	// +-----------------------------------------------------------------------+
	// | Public POST methods                                                   |
	// +-----------------------------------------------------------------------+
	
	/**
	 * Creates a new user. Returns info for the user created
	 * @param   string  $username  The username to create
	 * @return  json
	 */
	public function create_new_user($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request('POST', 'CreateNewUser', $args);
	}
	
	/**
	 * Sends from a user to a Reddcoin address. Returns the resulting transaction ID
	 * @param   string  $username  The username to send from
	 * @param   string  $address   The Reddcoin address to send to
	 * @param   float   $amount    The amount to send
	 * @return  string
	 */
	public function send_to_address($username_from, $address, $amount)
	{
		$args = array(
			'UsernameFrom' => $username_from,
			'AddressTo' => $address,
			'Amount' => $amount
		);
		
		return $this->_request('POST', 'SendToAddress', $args);
	}
	
	/**
	 * Moves coins from one user to another. Returns "Success" or 
	 * @param   string  $username_from  The username to move from
	 * @param   string  $username_to    The username to move to
	 * @param   float   $amount         The amount to move
	 * @return  string
	 */
	public function move_to_user($username_from, $username_to, $amount)
	{
		$args = array(
			'UsernameFrom' => $username_from,
			'UsernameTo' => $username_to,
			'Amount' => $amount
		);
		
		return $this->_request('POST', 'MoveToUser', $args);
	}

}
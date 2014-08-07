<?php

/**
 * reddapi-php
 * ReddAPI.class.php
 * PHP wrapper for ReddAPI, the Reddcoin API
 * 
 * @author  Devin Henderson <code@devhen.net>
 * @version 2014.08.07.1
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
	 * Private function for making a request using POST
	 * @param   string  $cmd   Operation
	 * @param   array   $args  Arguments
	 * @return  json
	 */
	private function _request_post($cmd, $args=array())
	{
		$args = json_encode(array('APIKey' => $this->key_post) + $args);
		
		$url = 'https://api.reddapi.com/v1/json/'.$cmd;
		
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: '.strlen($args))
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
		
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
	private function _request_get($cmd, $args=array())
	{
		$args = implode('/', array('APIKey' => $this->key_get) + $args);
		
		$url = 'https://api.reddapi.com/v1/json/'.$cmd.'/'.$args;
		
		$curl  = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
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
	 * @return  array of
	 *				json->DateCreated string
	 *					->DepositAddress string
	 *					->Username string
	 */
	public function get_user_list()
	{
		return $this->_request_get('GetUserList');
	}
	
	/**
	 * Gets info for a user
	 * @param   string  $username  The username to get info for
	 * @return  json->DateCreated string
	 * 				->DepositAddress string
	 * 				->Username string
	 */
	public function get_user_info($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request_get('GetUserInfo', $args);
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
		
		return $this->_request_get('GetUserBalance', $args);
	}
	
	/**
	 * Gets balance detail for a user
	 * @param   string  $username  The username to get balance for
	 * @return  json->ConfirmedBalance string
	 * 				->PendingDeposits string
	 */
	public function get_user_balance_detail($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request_get('GetUserBalanceDetail', $args);
	}
	
	// +-----------------------------------------------------------------------+
	// | Public POST methods                                                   |
	// +-----------------------------------------------------------------------+
	
	/**
	 * Creates a new user. Returns info for the user created
	 * @param   string  $username  The username to create
	 * @return  json->DateCreated string
	 * 				->DepositAddress string
	 * 				->Username string
	 */
	public function create_new_user($username)
	{
		$args = array(
			'Username' => $username
		);
		
		return $this->_request_post('CreateNewUser', $args);
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
		
		return $this->_request_post('SendToAddress', $args);
	}
	
	/**
	 * Moves coins from one user to another. If successful returns "Success" 
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
		
		return $this->_request_post('MoveToUser', $args);
	}

}
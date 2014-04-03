<?php

/**
 * reddapi-php
 * PHP wrapper for ReddAPI, the Reddcoin API
 * 
 * @author Devin Henderson <devin@six19.com>
 */
 
class ReddAPI
{

	/**
	 * Private variables
	 */
	 
	private $api_key;
	private $valid_key = false;
	
	/**
	 * Validate the API key
	 */
	private function validate_key() {
		
		// Not done yet. Waiting for changes to be finalized with beta API
		/*
		// Return true/false if key is valid
		if ($validate == "Invalid API Key!")
			$this->valid_key = false;
		else
			$this->valid_key = true;
		return $this->valid_key;
		*/
		return false;
	}
	
	/**
	 * Use curl if available
	 */
	private function _request($cmd) {
		
		if(function_exists('curl_version')) {
			return $this->_request_curl($cmd);
		} else {
			return $this->_request_file($cmd);
		}
		
	}

	private function _request_curl($cmd) {
		
		$url =  'https://www.reddapi.com/v1/json/'.$cmd;
		
		// Initiate curl and set headers/options
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Execute the curl request
		$result = curl_exec($ch);
		curl_close($ch);
		
		// Return response object or fail
		return $result ? json_decode($result) : false;        
	}
	
	private function _request_file($cmd) {
		
		$url = 'https://www.reddapi.com/v1/json/'.$cmd;
		
		// Execute the request
		$result = file_get_contents($url)
		
		// Return response object or fail
		return $result ? json_decode($result) : false;        
	}
	
	/**
	* API Key set and get
	*/
	public function set_key($key)
	{
		$this->api_key = $key;
		return $this->validate_key();
	}

	public function get_key($key)
	{
		return $this->api_key;
	}

	/**
	 * Creates a new user
	 * @param	string	$username	The username to create
	 * @return	json
	 */
	public function create_new_user($username) {
		
		return $this->_request('CreateNewUser/'.$this->get_key().'/'.$username);
		
	}

	/**
	 * Gets user list
	 * @param	void
	 * @return	json
	 */
	public function get_user_list() {
		
		return $this->_request('GetUserList/'.$this->get_key());
		
	}

	/**
	 * Gets info for a user
	 * @param	string	$username	The username to get info for
	 * @return	json
	 */
	public function get_user_info($username) {
		
		return $this->_request('GetUserInfo/'.$this->get_key().'/'.$username);
		
	}

	/**
	 * Gets balance for a user
	 * @param	string	$username	The username to get balance for
	 * @return	json
	 */
	public function get_user_balance($username) {
		
		return $this->_request('GetUserInfo/'.$this->get_key().'/'.$username);
		
	}

	/**
	 * Sends to a Reddcoin address
	 * @param	string	$username	The username to send from
	 * @param	float	$amount		The amount to send
	 * @param	string	$address	The Reddcoin address to send to
	 * @return	json
	 */
	public function send_to_address($username, $amount, $address) {
		
		return $this->_request('SendToAddress/'.$this->get_key().'/'.$username.'/'.$amount.'/'.$address);
		
	}

	/**
	 * Moves coins from one user to another
	 * @param	string	$username_from	The username to move from
	 * @param	float	$amount			The amount to move
	 * @param	string	$username_to	The username to move to
	 * @return	json
	 */
	public function move_to_user($username_from, $amount, $username_to) {
		
		return $this->_request('MoveToUser/'.$this->get_key().'/'.$username.'/'.$amount.'/'.$address);
		
	}

}
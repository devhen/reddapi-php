reddapi-php
===========

PHP wrapper for ReddAPI, the Reddcoin API


### Available Methods:

#### get_user_list()
```php
/**
 * Gets a list of all users
 * @param   void
 * @return  array
 */
public function get_user_list()
```

#### get_user_info()
```php
/**
 * Gets info for a user
 * @param   string  $username  The username to get info for
 * @return  json
 */
public function get_user_info($username)
```

#### get_user_balance
```php
/**
 * Gets balance for a user
 * @param   string  $username  The username to get balance for
 * @return  float
 */
public function get_user_balance($username)
```

#### create_new_user()
```php
/**
 * Creates a new user. Returns info for the user created
 * @param   string  $username  The username to create
 * @return  json
 */
public function create_new_user($username)
```

#### send_to_address()
```php
/**
 * Sends from a user to a Reddcoin address. Returns the resulting transaction ID
 * @param   string  $username  The username to send from
 * @param   string  $address   The Reddcoin address to send to
 * @param   float   $amount    The amount to send
 * @return  string
 */
public function send_to_address($username_from, $address, $amount)
```

#### move_to_user()
```php
/**
 * Moves coins from one user to another. If successful returns "Success" 
 * @param   string  $username_from  The username to move from
 * @param   string  $username_to    The username to move to
 * @param   float   $amount         The amount to move
 * @return  string
 */
public function move_to_user($username_from, $username_to, $amount)
```


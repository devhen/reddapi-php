<?php
// Include the ReddAPI class
include("ReddAPI.class.php");

// You can instantiate the ReddAPI object using no arguments and then set your API keys later:
$api = new ReddAPI();
// ...
$api->set_key_get('iVEH17M2RYiE3csHgeT2Cuelr7dM5c8wTgsYTq0ufXv62lSuU08qv6zwp3Z6286n');
$api->set_key_post('JkA24a86VB153ndVfkjW8anpH3bFWB427HdqxoJfpTkm83aV2atc3Gzh5UtB72lU');

// Or you can instantiate the object using your API keys (first the GET key, then the POST key):
$api = new ReddAPI(
	'iVEH17M2RYiE3csHgeT2Cuelr7dM5c8wTgsYTq0ufXv62lSuU08qv6zwp3Z6286n',
	'JkA24a86VB153ndVfkjW8anpH3bFWB427HdqxoJfpTkm83aV2atc3Gzh5UtB72lU'
);

// We can get a json object containing all of our users:
$users = $api->get_user_list();

// Which returns something like this:
var_dump($users);
/*
object(stdClass)#1 (1) {
  ["GetUserListResult"]=>
  array(2) {
    [0]=>
    object(stdClass)#2 (3) {
      ["DateCreated"]=>
      string(26) "/Date(1396273679050+0000)/"
      ["DepositAddress"]=>
      string(34) "RapvkV4sPRZdqrizD8MhksPX8ME9fWaWfS"
      ["Username"]=>
      string(8) "billybob"
    }
    [1]=>
    object(stdClass)#3 (3) {
      ["DateCreated"]=>
      string(26) "/Date(1396279760020+0000)/"
      ["DepositAddress"]=>
      string(34) "Ru6rY4cGrGiZSD8KyoMsBKXEuLqoNAxN3v"
      ["Username"]=>
      string(9) "mynewuser"
    }
  }
}
*/

// We can create a new user:
$user_info = $api->create_new_user('username');

// Which returns info on the user that it created:
var_dump($user_info);
/*
object(stdClass)#4 (3) {
  ["DateCreated"]=>
  string(26) "/Date(1396581105383+0000)/"
  ["DepositAddress"]=>
  string(34) "Rbno6yFpJuMXNRPxmquiuCUbEdSv3urXPq"
  ["Username"]=>
  string(8) "username"
}
*/

// More example code coming very soon. Sit tight.

?>
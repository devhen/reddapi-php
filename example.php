<?php
// Include the ReddAPI class
include("ReddAPI.php");

// There are two ways to instantiate the object.

// You can instantiate the ReddAPI object using no arguments and then set your API key later:
$api = new ReddAPI();
// ...
$api->set_key('iVEH17M2RYiE3csHgeT2Cuelr7dM5c8wTgsYTq0ufXv62lSuU08qv6zwp3Z6286n');

// Or you can instantiate the object using your API key:
$api = new ReddAPI('iVEH17M2RYiE3csHgeT2Cuelr7dM5c8wTgsYTq0ufXv62lSuU08qv6zwp3Z6286n');

// We can get json object containing all of our users:
$users = $api->get_user_list();
var_dump($users);

// Which returns something like this:
/*
object(stdClass)#1 (1) {
  ["GetUserListResult"]=>
  array(5) {
    [0]=>
    object(stdClass)#5 (3) {
      ["DateCreated"]=>
      string(26) "/Date(1396273679050+0000)/"
      ["DepositAddress"]=>
      string(34) "RapvkV4sPRZdqrizD8MhksPX8ME9fWaWfS"
      ["Username"]=>
      string(8) "billybob"
    }
    [1]=>
    object(stdClass)#6 (3) {
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
var_dump($user_info);

// This function returns info on the user that was created:
/*
object(stdClass)#8 (3) {
  ["DateCreated"]=>
  string(26) "/Date(1396581105383+0000)/"
  ["DepositAddress"]=>
  string(34) "Rbno6yFpJuMXNRPxmquiuCUbEdSv3urXPq"
  ["Username"]=>
  string(8) "username"
}
*/


?>
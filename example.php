<?php
// Include the ReddAPI class
include("ReddAPI.class.php");

// You can instantiate the ReddAPI object using no arguments and then set your API keys later:
$api = new ReddAPI();
// ...
$api->set_key_get('7qK85UWoFMoW1jZGOxDyayip0Y4XK5cRAdztAW8TrzlCMpx1r8ANvE3gJ5GhY8eK');
$api->set_key_post('hb7uKv6ycDepxAqp5RouSz7zS5tf4Hgvg3E85nMeF48YcKr5cEgqOzCpcGeOBy36');

// Or you can instantiate the object using your API keys (first the GET key, then the POST key):
$api = new ReddAPI(
	'7qK85UWoFMoW1jZGOxDyayip0Y4XK5cRAdztAW8TrzlCMpx1r8ANvE3gJ5GhY8eK',
	'hb7uKv6ycDepxAqp5RouSz7zS5tf4Hgvg3E85nMeF48YcKr5cEgqOzCpcGeOBy36'
);

// We can get an array of all of our users:
$users = $api->get_user_list();

// Which returns something like this:
var_dump($users);
/*
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
*/

// We can create a new user:
$user = $api->create_new_user('new_user');

// Which returns info on the user that it created:
var_dump($user);
/*
object(stdClass)#4 (3) {
  ["DateCreated"]=>
  string(26) "/Date(1396655499973+0000)/"
  ["DepositAddress"]=>
  string(34) "RbtHkJ35zXAmvJ4kgNqQ7sdm7cTjnVtRZ9"
  ["Username"]=>
  string(8) "new_user"
}
*/

// Among that info is the user's Reddcoin address. We can now send coins to that address.
var_dump($user->DepositAddress);
/*
string(34) "RbtHkJ35zXAmvJ4kgNqQ7sdm7cTjnVtRZ9"
*/

// Once we have sent coins to the address we can check the user's balance:
$balance = $api->get_user_balance($user->Username);

// Coins will show up after 6 confirmations.
var_dump($balance);
/*
float(110.20)
*/

// We can now send coins from that user to any Reddcoin address:
$tx = $api->send_to_address($user->Username, 'RwbiZSqZduJdXPfhP48E5pxDQtpF6VhhAd', 50.1);

// Which returns the TX id for the transaction
var_dump($tx);
/*
string(64) "271158a53ac80fdeea96ec2131fc807c0b0c7b1849ab7da142d7b06fa42b3d94"
*/

// We can also move coins from one user to another:
$user_from = $user;
$user_to = $api->get_user_info('anotheruser');
$move_result = $api->move_to_user($user_from->Username, $user_to->Username, 50.1);

// Which should return "Success":
var_dump($move_result);
/*
string(7) "Success"
*/

?>
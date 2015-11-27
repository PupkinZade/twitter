<?php
/*
It displays a list of all the friends/followers of this user. List of id.
*/

require "autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
$username='twitter'; //username which will parse

$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
$cursor=-1;
	
do {
	// for FOLLOWING
	$twitter = $connection->get('friends/ids', array('cursor'=>$cursor, 'screen_name' => $username, 'count' => 5000));
/*
or for FOLLOWERS
$twitter = $connection->get('followers/ids', array('cursor'=>$cursor, 'screen_name' => $username, 'count' => 5000));
*/

foreach ($twitter->ids as $id) {
echo $id."<br />"; }
$cursor=$twitter->next_cursor;
}
while ($twitter->next_cursor!=0)
	?>
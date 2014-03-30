<?php
/*
Выводит в виде списка всех фолловеров пользователся. Список в виде id.
(c) Max Makarov (PupkinZade Inc.), 2012, 2013 (http://pupkinzade.tumblr.com)
*/

require_once 'src/twitter.class.php';

// Settings
$username='twitter';
$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
 
$cursor=-1;

	$connection = new Twitter($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
do {
	// для FOLLOWING
	$twitter = $connection->request('friends/ids', 'GET', array('cursor'=>$cursor, 'screen_name' => $username, 'count' => 5000));

/*
или для FOLLOWERS
$twitter = $connection->request('followers/ids', 'GET', array('cursor'=>$cursor, 'screen_name' => $username, 'count' => 5000));
*/

foreach ($twitter->ids as $id) {
echo $id."<br />"; }
$cursor=$twitter->next_cursor;
}

while ($twitter->next_cursor!=0)
	?>

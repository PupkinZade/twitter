<?
/*
A simple php script to automatically follow on Twitter.
Checks your followers - whether they follow you around and if not, then you follow them.

version    1.0
(c) Max Makarov (PupkinZade Inc.), 2012, 2013 (http://pupkinzade.tumblr.com)
*/
require_once 'src/twitter.class.php';

// Settings

$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
$numb=50; /* you need to check how many followers. Will follow your readers with the latest. Be aware of the limits of Twitter */
$nik="Twitter_nik"; /* your nickname */

// end setting

	$connection = new Twitter($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
	
	$twitter = $connection->request('followers/ids', 'GET', array('screen_name' => $nik, 'count'=>$numb));
		$MassTweets=$twitter->ids;

$followers = implode(',', $MassTweets);
$twi = $connection->request('friendships/lookup', 'GET', array('user_id' => $followers));

for($i=0;$i<$numb;$i++) { 
if($twi[$i]->connections[0]!="following") {
$connection->request('friendships/create', 'POST', array('user_id' =>$twitter->ids[$i], 'follow' => 'true'));
echo "<li>You follow: ".$twitter->ids[$i]."</li>";
}
else {}
}
?>

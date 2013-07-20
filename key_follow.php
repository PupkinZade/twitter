<? 
/*
A simple php script to automatically follow on Twitter.
Follow people from the keyword search results.

(c) Max Makarov (PupkinZade Inc.), 2012, 2013 (http://pupkinzade.tumblr.com)
*/
require_once 'src/twitter.class.php';

// Settings

$nik="Twitter_nik"; /* your nickname */
$query="FollowBack"; /* The word for which the search is performed on twitter */
$twi_limit = 3; /* number of people for whom you need to follow a maximum of 100 times */
$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
 
// end setting

$connection = new Twitter($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
$twitter = $connection->search($query);
for ($i=0;$i<$twi_limit;$i++) {
$screen_name=$twitter[$i]->user->screen_name;
$twi = $connection->request('friendships/show', 'GET', array('source_screen_name' => $nik, 'target_screen_name'=> $screen_name));
if($twi->relationship->source->following!="false") {
$connection->request('friendships/create', 'POST', array('screen_name' =>$screen_name, 'follow' => 'true'));
echo "<li>You follow: ".$screen_name."</li>";
}
else {}
}
?>
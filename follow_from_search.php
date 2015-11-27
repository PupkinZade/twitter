<? 
/*
* A simple php script to automatically follow on Twitter from search.
* Follow people from the keyword search results.
*/

require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
$query="followback"; //search word
$count = 3; // number of people for follow 

$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);

$twitter = $connection->get('search/tweets', array('q' => $query, 'count'=>$count));
foreach ($twitter->statuses as $status) {
if($status->user->following==null) {
$connection->post('friendships/create', array('screen_name' =>$status->user->screen_name, 'follow' => 'true'));
echo "<li>You follow: ".$status->user->screen_name."</li>";
} 

}
?>
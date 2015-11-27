<?php
/* 
 * AutoFollow Tool For Twitter
 * Version: 3.0
 * FUNCTIONS: Follow Back no bots and send Direct Messages
 */
/*********** CONFIGURATION ***********/
/* 
 * Create a new app by going to https://dev.twitter.com/apps/new and create a new app with Read, write, and direct messages permissions.
 * Once the app is created and you generated your access token, you will have the keys needed for below. 
 */
require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

/*----------SETTING------------*/
$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
$count=10; // <=100 how to check
define("DIRECT_MESSAGE", "Thank you for the follow!"); // Message, who began to read. Leave empty if you do not want to send.
/*----------SETTING------------*/

$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);

$type='user_id';
$friends = $connection->get('followers/ids', array('cursor' => -1, 'count' => $count)); // list of followers
$followers = implode(',', $friends->ids);
$friends = $connection->get('friendships/lookup', array($type => $followers)); // tokens of friendship
foreach ($friends as $friend) { 
	if($friend->connections[0]!="following") {
	$followerIds[] = $friend->id;
											}
	}
$followers = implode(',', $followerIds);
$friends = $connection->get('users/lookup', array($type => $followers)); // Information about the user
	
	foreach ($friends as $friend) { 
	echo '<br />';
	$strike=0;
	$user=$friend->id;
	$name=$friend->screen_name;
if($friend->default_profile_image==true) { echo $name .' bot'; continue;} 
if($friend->default_profile==true) {echo $name .' bot'; continue;} // design by default
if($friend->listed_count<10) {$strike++;} // lists
if($friend->followers_count<50) {$strike++;} // followers
if($friend->friends_count>10000) {$strike++;} // friends
if(strlen(preg_replace('/[^\d]/','',$name))>=3) {$strike++;} // the number of digits in screen name
if($friend->statuses_count<1000){$strike++;} // tweets
if($friend->favourites_count<5) {$strike++;} // favorites
if($friend->status->retweeted_status!=null) {$strike++;} // first tweet == retweet? basically do not need to check. further there is a check in the last 200 posts
if($friend->status->entities->urls[0]!=null) {$strike++;} // similar test is whether there is a link
if(($friend->followers_count/$friend->friends_count)<=1.18) {$strike++;} // the ratio of followers/friends
if($strike<=2) {
$count_tweets=($friend->statuses_count<=200) ? $friend->statuses_count:200; // 200 or less
$timeline = $connection->get('statuses/user_timeline', array($type => $user, 'include_rts' => 'true', 'count'=>$count_tweets,'contributor_details'=>'false','trim_user'=>'true'));
// Get the latest tweets User
$retweets_count=$links_count=$image_count=$mention_count=0;
foreach ($timeline as $statuses) { 
	if($statuses->retweeted_status!=null) {$retweets_count++;} // RTs
	if($statuses->entities->urls[0]!=null && $statuses->entities->media[0]->media_url==null ) {$links_count++;}  // tweets with links
	if($statuses->entities->media[0]->media_url!=null && $statuses->entities->media[0]->type=='photo') {$image_count++;} // tweets with images
	if($statuses->entities->user_mentions[0]!=null && $statuses->retweeted_status==null) {$mention_count++;} // tweets with mentions
	}
// 	relation to the number of counters of various tweets ($count_tweets)
if(($retweets_count/$count_tweets)>=0.3) {$strik+=3;} 
if(($links_count/$count_tweets)>=0.4) {$strike+=3;}   
if(($image_count/$count_tweets)>=0.7) {$strike+=3;}  
if(($image_count/$count_tweets)==0) {$strike++;}	
if(($mention_count/$count_tweets)<=0.1) {$strike++;} 
if(($mention_count/$count_tweets)==0) {$strike+=3;} 
echo '<p>'.$image_count/$count_tweets.' images</p>
<p>'.$links_count/$count_tweets.' links</p>
<p>'.$retweets_count/$count_tweets.' RTs</p>	
<p>'.$mention_count/$count_tweets.' Mention</p>';
}	
	
if($strike<=2) { 
FollowUser($user);
if (FollowUser($user)) {		
/* uncomment if you want to save the following results to a file
$f = fopen('file.txt', 'a');
    fwrite($f, $user . PHP_EOL);
    fclose($f);	
	*/
				// send DM
				if (DIRECT_MESSAGE)
					$connection->post('direct_messages/new', array($type => $user, 'text' => DIRECT_MESSAGE));
			}
echo $name .' follow '. $strike .' strikes'; continue;
}
if($strike>=3) { echo $name .' bot Sheldon with'. $strike .' strikes'; continue;}
	
	}
// Follow by user id
	function FollowUser($id) {
	global $connection,$type;
	$follow=$connection->post('friendships/create', array($type => $id, 'follow' => 'true'));
		if ($follow->following === true) {
		return true;
		} else
		return false;
	}
	
	
?>
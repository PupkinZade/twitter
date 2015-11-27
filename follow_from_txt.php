<?php 
/* 
*  Follow from txt list. IDs or user_name
*/
require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$consumer_key=""; /* your CONSUMER-KEY */
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /* your OAUTH-TOKEN */
$oauth_sec=""; /* your OAUTH-SECRET */
$file='/home/uXXXXXX/public_html/followers.txt';  /* Please full path to the file */
$listnik='user_id';  // can be  'nikname' or 'user_id', if the list of nicks or ids
$numb=3;  /* the number of followers that follow */



$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
for($j=0;$j<$numb;$j++) {
$filearray=file($file);
if(is_array($filearray))
{
$follower=$filearray[0]; 
$twitter =$connection->post('friendships/create', array($listnik =>$follower, 'follow' => 'true'));
echo "<li>You followed: ". $follower ."</li>";
$result = array_slice(array($file), $numb); 
    $f=fopen($file,'w');
    for($i=1;$i<sizeof($filearray);$i++)
    {
        fwrite($f,$filearray[$i]);
    }
    fclose($f);
}
}
?>
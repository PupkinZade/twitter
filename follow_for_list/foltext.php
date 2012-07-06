<? 
/* PupkinZade Inc.
* Russian and English version. Allows follow from list
* Русская и английская версии. Позволяет фолловить из списка
*/
$file_index='file.txt'; /* полный путь к файлу/full path name */
$numb=3; /*  количество фолловеров за которыми последуем, оптимальное число 3/the number of followers that follow, the optimal number 3 */

$consumer_key=""; /* your CONSUMER-KEY*/
$consumer_sec=""; /* your CONSUMER-SECRET */
$oauth_tok="";  /*  your OAUTH-TOKEN */
$oauth_sec=""; /*  your OAUTH-SECRET */

/** 
* Keys to the application can be obtained here/Ключи для приложения можно получить тут: http://pupkin.u-gu.ru/twitter/Pupkinzadeauth/ 
*
* Или создать свое приложение тут/Or create your application here:https://dev.twitter.com/apps/new 
*/


$prov=file_get_contents($file_index);
if($prov=="") {
echo "<b>The end of file</b>";
} 

else {
for($e=0;$e<$numb;$e++) {
$filef=file($file_index);
$follower=$filef[$e];
$status="follow @" . $follower;

	require_once 'twitteroauth/twitteroauth.php';
	set_time_limit(0);
	$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
	$connection->format = 'xml';

echo "<li>You followed: ". $follower ."</li>";
$connection->post('statuses/update', array('status'=>$status));
}
$file = file($file_index); 
$result = array_slice($file, $numb-2); 
file_put_contents($file_index, implode($result), LOCK_EX); 
}
?>
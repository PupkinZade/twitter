<? 
$file_index='file.txt'; /* полный путь к файлу */	 
$numb=3; /* количество фолловеров за которыми последуем, оптимальное число 3*/

$consumer_key=""; /* тут ваш CONSUMER-KEY */
$consumer_sec=""; /* тут ваш CONSUMER-SECRET */
$oauth_tok="";  /* тут ваш OAUTH-TOKEN */
$oauth_sec=""; /* тут ваш OAUTH-SECRET */

/** 
* Ключи для приложения можно получить тут http://pupkin.u-gu.ru/twitter/Pupkinzadeauth/ 
*
* Или создать свое приложение тут https://dev.twitter.com/apps/new 
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

echo "<li>Вы последовали за: ". $follower ."</li>";
$connection->post('statuses/update', array('status'=>$status));
}
$file = file($file_index); 
$result = array_slice($file, $numb-2); 
file_put_contents($file_index, implode($result), LOCK_EX); 
}
?>
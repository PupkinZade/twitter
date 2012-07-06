<?php
/* PupkinZade Inc. */
class GetLastTwitt{
  
  public $cache_file = './last_twitt.txt';
  public $cache_period = 0;
  
  private $username;
  private $dom;
  private $get_xml_method = 'curl';
  
  function __construct($username){
    $this->username = $username;
  }
  
  private function setEnv(){
    $feed_url = 'http://twitter.com/statuses/user_timeline/'.$this->username.'.rss';
    
    $this->dom = new DOMDocument();
    $this->dom->load($feed_url);
  }
  
  private function returnLastTwitt (){
    if ($this->cache_period != 0)
      if (file_exists($this->cache_file))
        if ($this->cache_period > $this->getCacheDateDiff())
          return $this->getLastFromCache();
    
    return $this->getLastFromWeb($this->username);
  }
  
  private function getLastFromWeb($username){
    $this->setEnv();
    $rows = $this->dom->getElementsByTagName('item');
    $last_twitt = $rows->item(0)->getElementsByTagName('title')->item(0)->nodeValue;
    $this->cache_twitt($last_twitt);
    return $last_twitt;
  }
  
  private function cache_twitt($msg){
    $handle = fopen($this->cache_file,'w');
    fwrite($handle, $msg);
    fclose($handle);
  }
  
  private function getCacheDateDiff(){
    return date('U') - filemtime($this->cache_file);
  }
  
  private function getLastFromCache(){
    $handle = fopen($this->cache_file,'r');
    $cached_twitt = fread($handle, filesize($this->cache_file));
    fclose($handle);
    return $cached_twitt;
  }
  
  final function getLast(){
    return $this->returnLastTwitt();
  }
  
}


$a = new GetLastTwitt('skaizer'); /* тут ваш ник */
echo $a->getLast();

?>

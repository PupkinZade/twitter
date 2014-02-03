[Twitter for PHP](https://github.com/PupkinZade/twitter)
================================

A simple collection of php scripts to automate your twitter


Requirements
------------
- PHP (version 5 or better)
- Basic knowledge of Twitter API 1.1 and PHP 

 


Usage
-----
Sign in to the http://twitter.com and register an application from the http://dev.twitter.com/apps page. Remember
to never reveal your consumer secrets. Click on My Access Token link from the sidebar and retrieve your own access
token. Now you have consumer key, consumer secret, access token and access token secret.

Create object using application and request/access keys

	$connection = new Twitter($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);

The send() method updates your status. The message must be encoded in UTF-8:

	$twitter->send('I am fine today.');

Get the first 5000 followings

	$twitter = $connection->request('friends/ids', 'GET', array('screen_name' => 'Username'));
	foreach ($twitter->ids as $id) {
	echo $id."<br />"	
		}

-----
Project at GitHub: https://github.com/PupkinZade/twitter
Twitter's API documentation: http://dev.twitter.com/doc

(c) Max Makarov (PupkinZade Inc.), 2012, 2013 (http://pupkinzade.tumblr.com)

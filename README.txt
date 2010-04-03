<?php

require_once 'class.cachemoney.php';

/*------------------------------------------------------------------------------------------------------*/
// This class will store your data in a file
//
// PARAMETERS: 
//
// public $file	 = 'class.stored.php'; 	(the file in which to store your data)
// public $class = 'Stored';		(the class name that will hold your data)
// public $age	 =  3;			(how many days you want your data to be valid for)
// public $force =  true;		(if you want to force a cache clear no matter what)
// public $queries;			(an array of data which will be stored)
//
// EXAMPLE:
//
// $data = array(
//		'popularTags'	=>	array('film','35mm','crazy stuff'),
//		'popularUsers'	=>  	array('thom,'jeff','barack'),
//		'popularSongs'	=>	array('Song 1','Song 2','Song 3'));
//
// $params = array(
//		'age'	=>	3,
//		'file'	=>	'class.stored.php',
//		'class'	=>	'Stored');
// new CacheMoney($params,$data);
// 
// The above will create this class structure similar to this:
/*
   	Class Stored {
		
		public static $popularTags  = [serialized array of $data['popularTags']];
		public static $popularUsers = [serialized array of $data['popularUsers']];
		public static $popularSongs = [serialized array of $data['popularSongs']];

	}

*/
// You will know be able to access your data array by doing unserialize(Stored::$populartags)
// There will also be a function in the class to see if it is expired, like so:
// Stored::isExpired()
// I suck at making documentation, sorry!
// jeffmicklos@gmail.com
/*------------------------------------------------------------------------------------------------------*/

//USE CASES:

/*------------------------------------------------------------------------------------------------------*/
// Option 1: 
// Check if data (as supplied by the params) is expired
// If it is expired, send the data to be cached to the setData method
/*------------------------------------------------------------------------------------------------------*/


$params = array(
		'age'	=>	3,
		'file'	=>	'class.stored.php',
		'class'	=>	'Stored');

$cache = new CacheMoney($params);

if($cache->isExpired()){
	
	$data = array(
			'popularTags'	=>	array('film','35mm','crazy stuff'),
			'popularUsers'	=>  	array('thom,'jeff','barack'),
			'popularSongs'	=>	array('Song 1','Song 2','Song 3'));

	
	$cache->setData($data);
	$cache->buldCache();

}

/*------------------------------------------------------------------------------------------------------*/
// Option 2: 
// Clear cache no matter what by sending 'force' => true in the params
/*------------------------------------------------------------------------------------------------------*/

$params = array(
			'age'	=>	3,
			'file'	=>	'class.stored.php',
			'class'	=>	'Stored',
			'force'	=>	true);



$data = array(
		'popularTags'	=>	array('film','35mm','crazy stuff'),
		'popularUsers'	=>  	array('thom,'jeff','barack'),
		'popularSongs'	=>	array('Song 1','Song 2','Song 3'));

$data = new CacheMoney($params,$data);

/*------------------------------------------------------------------------------------------------------*/
// Option 3: 
// Send the params and data then let it do it's thing
// If force isn't true and the data isn't expired, nothing will happen
/*------------------------------------------------------------------------------------------------------*/

$params = array(
			'age'	=>	3,
			'file'	=>	'class.stored.php',
			'class'	=>	'Stored');

$data = array(
		'popularTags'	=>	array('film','35mm','crazy stuff'),
		'popularUsers'	=>  	array('thom,'jeff','barack'),
		'popularSongs'	=>	array('Song 1','Song 2','Song 3'));


$data = new CacheMoney($params,$data);

?>
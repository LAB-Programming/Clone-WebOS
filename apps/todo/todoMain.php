<?php

	include '../lib/SystemScheduler.php';
	session_start();
	$testEvent = new Event('foobar', '../todo/test.php', 'todo', time() + 60);
	$testEvent2 = new Event('Random', '../todo/test.php', 'todo', time() + 60);
	$privateEvent = new privateEvent('Random', '../todo/test.php', 'todo', time() + 60, $_SESSION['UserName']);
	//var_dump($testEvent);
	$systemEventHandle = new SystemScheduler('todo');

	//$systemEventHandle->addEvent($privateEvent);
	//var_dump($systemEventHandle->getEvents());
	foreach($systemEventHandle->getEvents() as $event){
		echo $event->runScript();
	}
	//$systemEventHandle->addEvent($testEvent2); 



?>
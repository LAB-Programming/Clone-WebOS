<?php

	include '../lib/SystemScheduler.php';
	session_start();
	$testEvent = new Event('foobar', '../todo/test.php', 'todo', time() + 60);
	$testEvent2 = new Event('Random', '../todo/test.php', 'todo', time() + 60);
	$privateEvent = new PrivateNotificationEvent($_SESSION['UserName'], 'todo', time() + 60, 'Random', '../todo/test.php', "hello world");
	//var_dump($testEvent);
	$systemEventHandle = new SystemScheduler('todo');
	$systemEventHandle->addEvent($privateEvent);

	//$systemEventHandle->addEvent($privateEvent);
	//var_dump($systemEventHandle->getEvents());
	foreach($systemEventHandle->getEvents() as $event){
		echo $event->runScript();
		echo $event->getBody();
	}
	//$systemEventHandle->addEvent($testEvent2); 



?>
<?php

	include '../lib/SystemScheduler.php';

	$testEvent = new Event('foobar', '../todo/test.php', 'todo', time() + 60);
	$testEvent2 = new Event('Random', '../todo/test.php', 'todo', time() + 60);
	//var_dump($testEvent);
	$systemEventHandle = new SystemScheduler('todo');

	//$systemEventHandle->addEvent($testEvent);
	//var_dump($systemEventHandle->getEvents());
	foreach($systemEventHandle->getEvents() as $event){
		echo $event->runScript();
	}
	//$systemEventHandle->addEvent($testEvent2); 



?>
<?php

	include '../lib/SystemScheduler.php';
	require_once '../system-Scheduler/systemEvent.php';

	$testEvent = new Event('foobar', '../todo/test.php', 'todo', time() + 1000);
	$testEvent2 = new Event('foo', '../todo/test.php', 'todo', time() + 1000);
	//var_dump($testEvent);
	$systemEventHandle = new SystemScheduler('todo');

	$systemEventHandle->addEvent($testEvent);
	//$systemEventHandle->newEvent($testEvent2); 



?>
<?php
	function __autoload($classname) {
		include_once('./controllers/' . strtolower($classname) . ".php");
	}

	session_start();

	Router::go();
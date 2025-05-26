<?php

define('PROJECT_DIR', realpath(__DIR__));

// register Autoloader
require_once PROJECT_DIR.'/src/Lib/Autoloader.php';
new Autoloader(PROJECT_DIR);

// create Application
$application = new \Application\Application();
$application->run($argv);

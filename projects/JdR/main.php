<?php

define('PROJECT_DIR', realpath(__DIR__));

// register Autoloader
require_once PROJECT_DIR.'/src/Lib/Autoloader.php';
new Autoloader(PROJECT_DIR);

$fileReader = new \Lib\File\FileReader(PROJECT_DIR.'/src/Lib/file/fileReader.php');
$data = $fileReader->read();

$factory = new ScenarioFactory();
$scenario = $factory->createScenarioFromFile('fesses');

var_dump($scenario);
die('End of the script'); 

// create Application
$application = new \Application\Application(
    dataDir: PROJECT_DIR.'/data'
);
$application->run(...$argv);

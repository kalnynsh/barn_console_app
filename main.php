#!usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Barn\services\Cow\CowService;
use Barn\repository\Db;
use Barn\repository\ChickenRepository;
use Barn\repository\CawRepository;
use Barn\services\Cow\ChickenService;

$cowNames = include __DIR__ . '/src/data/CowNames.php';
$chickensNames = include __DIR__ . '/src/data/ChickenNames.php';

$sqliteDsn = 'sqlite:' . __DIR__ . '/src/db/barnDb.sqlite';
$db = new Db($sqliteDsn);

$cowRepository = new CawRepository($db);
$chickenRepository = new ChickenRepository($db);

$cowService = new CowService($cowNames, $cowRepository);
echo $cowService->init();
echo '' . PHP_EOL;

$chickenServise = new ChickenService($chickensNames, $chickenRepository);
echo $chickenServise->init();
echo '' . PHP_EOL . PHP_EOL;

$cowService->printAllMilk();
$chickenServise->printAllEggs();

echo '' . PHP_EOL;
$cowService->printBest();
echo '' . PHP_EOL;

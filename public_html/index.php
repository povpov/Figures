<?php

chdir(dirname(__DIR__));
require_once './vendor/autoload.php';


$app = new \Application\ApplicationController();
$app->run();
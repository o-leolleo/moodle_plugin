<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$miner = new local_distance_miner();
$miner->init()->mine();

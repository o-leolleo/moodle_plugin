<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

(new local_distance_miner())->init()->mine();

echo "FINISH.\n";

<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$miner_job = new \local_distance\job\miner();
\core\task\manager::queue_adhoc_task($miner_job);

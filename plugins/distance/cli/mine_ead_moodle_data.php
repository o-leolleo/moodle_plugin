<?php
define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../classes/miner.php');

$report = new report_distance_miner();
echo $report->getQuery();

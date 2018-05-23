<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

print_r(\local_distance\models\mdl_course_categories::get_course_list());
echo "\n";
print_r(local_distance_miner::class);
echo "\n";
$miner = new local_distance_miner();
echo "starting mine...".PHP_EOL;
$miner->init()->mine();

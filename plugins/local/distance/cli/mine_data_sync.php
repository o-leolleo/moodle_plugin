<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

print_r(\local_distance\models\mdl_course_categories::get_course_list());
$miner = new local_distance_miner();
$miner->init()->mine(71);

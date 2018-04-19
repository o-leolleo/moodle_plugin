<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$groups = $DB->get_records_sql(\local_distance\models\groups::of_course, [ 13 ]);

foreach ($groups as $group) {
	try {
		$students = $DB->get_records_sql(\local_distance\models\groups::get_students, [ $group->id ]);
		var_dump($students);
	}
	catch (dml_read_exception $e){
		var_dump($e);
	}
}

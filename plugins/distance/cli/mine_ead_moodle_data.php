<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

use report_distance\models\mdl_course_categories;

echo "booting...\n";

$course_ids = mdl_course_categories::get_course_list();
$report = (new report_distance_miner())->init();

 //shared tables (should be views, but...)
echo "mounting students...\n";
$report->populate_students();

echo "mounting teachers...\n";
$report->populate_teachers();

echo "mounting posts...\n";
$report->populate_posts();

foreach($course_ids as $id) {
	try {
		// specific tables (should be views, but...)
		echo "STARTING FOR $id...\n";
		echo "mounting basis...\n";
		$report->populate_base($id);

		echo "mounting disciplines...\n";
		$report->populate_disciplines($id);

		echo "mounting aluno_ids...\n";
		$report->populate_alunos_ids($id);

		echo "mounting id_disciplinas...\n";
		$report->populate_course_ids($id);

		echo "populating the fucking log...\n";
		$report->populate_log_reduzido($id);

		echo "calculating transational distance...\n";
		$report->populate_transational_distance($id);
	}
	catch (dml_read_exception $e) {
		cli_problem($e->debuginfo);
	}
	finally {
		echo "DONE!\n";
	}
}

echo "cleaning temporary data...\n";
$report->purge_temp_data();

echo "FINISH.\n";

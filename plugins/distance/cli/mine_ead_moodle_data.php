<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$id = 88;

$report = new report_distance_miner();

try {
	$report->purge_temp_data();

	echo "mounting basis...\n";
	$report->populate_base($id);

	echo "mounting students...\n";
	$report->populate_students();

	echo "mounting teachers...\n";
	$report->populate_teachers();

	echo "mounting posts...\n";
	$report->populate_posts();

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
	echo "O FIM\n";
}

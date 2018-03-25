<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$id = 88;

$report = new report_distance_miner();

try {

	//$rs = $report->create_base('adm_publica', $id);

	$report->generate_base($id);

	//foreach($rs as $record) {
		////var_dump(\report_distance\models\basis::handle_semester($record->semestre));
		////var_dump(\report_distance\models\basis::handle_semester($record->semestre));
	//}

	//$rs->close();
}
catch (dml_read_exception $e) {
	cli_problem($e->debuginfo);
}
finally {
	echo "O FIM\n";
}
//catch (Exception $e) {
	//echo $e->getMessage()."\n";
	//echo $e->getLine()."\n";
//}
//var_dump($records);

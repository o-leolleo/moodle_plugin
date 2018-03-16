<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$id = 31;

$report = new report_distance_miner();

try {

	//$rs = $report->create_base('adm_publica', $id);

	var_dump(\report_distance\models\basis::get_min_semester($id));

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

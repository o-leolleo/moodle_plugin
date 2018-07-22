<?php
require_once('../../config.php');
require_once($CFG->libdir.'/csvlib.class.php');

use \local_distance\models\transational_distance;

$disciplina_id = required_param('disciplina_id', PARAM_INT);

$downloadfilename = clean_filename("export_csv");
$csvexport = new csv_export_writer('semicolon');
$csvexport->set_filename($downloadfilename); 

$rs = $DB->get_recordset_sql(transational_distance::select_by_discipline, [ $disciplina_id ]);

foreach ($rs as $record) {
	if (!isset($exporttitle)) {
		$exporttitle = array_keys((array) $record);
		$csvexport->add_data($exporttitle);
	} else {
		$csvexport->add_data((array) $record);
	}
}

$rs->close();


$csvexport->download_file();

<?php

use \report_distance\models\basis;

class report_distance_miner
{
	public function __construct() {}

	public function generate_base($course_id)
	{
		global $DB;

		$first_semester = basis::get_min_semester($course_id);
		$first_semester->name = basis::handle_semester($first_semester->name);

		$rs = $DB->get_recordset_sql(basis::get, [$course_id]);

		foreach($rs as $record) {
			// TODO most of this treatment should be internationalized
			// in the future, and those helper functions abandoned
			// for a query based soluction which doesn't need posprocessing
			$record->semestre = basis::handle_semester($record->semestre);
			$record->periodo = basis::calculate_period($record->semestre, $first_semester->name);
			$record->data_fim = basis::calculate_end_date($record->semestre, $record->periodo);

			try {
				$DB->insert_record(basis::table, $record);
			}
			catch(dml_write_exception $e) {
				cli_problem($e->debuginfo);
			}
		}

		$rs->close();
	}
}

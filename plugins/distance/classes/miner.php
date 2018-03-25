<?php

use \report_distance\models\basis;
use \report_distance\models\discipline;
use \report_distance\models\student;
use \report_distance\models\teacher;

class report_distance_miner
{
	public function __construct() {}

	public function populate_base($course_id)
	{
		$this->populate(basis::class, $course_id, basis::handler($course_id));
	}

	public function populate_students()
	{
		$this->populate(student::class);
	}

	public function populate_teachers()
	{
		$this->populate(teacher::class);
	}

	public function populate_posts()
	{
		$this->populate(posts::class);
	}

	public function populate_disciplines($course_id)
	{
		$this->populate(discipline::class, $course_id);
	}

	private function populate($model, $course_id = null, $handler = null)
	{
		global $DB;

		if (isset($course_id)) {
			$rs = $DB->get_recordset_sql($model::get, [$course_id]);
		}
		else {
			$rs = $DB->get_recordset_sql($model::get);
		}

		foreach ($rs as $record) {
			if (isset($handler)) {
				$record = $handler($record);
			}

			try {
				$DB->insert_record($model::table, $record);
			}
			catch (dml_write_exception $e) {
				cli_problem($e->debuginfo);
			}
		}

		$rs->close();
	}
}

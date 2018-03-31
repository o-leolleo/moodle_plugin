<?php

use \report_distance\models\basis;
use \report_distance\models\discipline;
use \report_distance\models\student;
use \report_distance\models\post;
use \report_distance\models\teacher;
use \report_distance\models\aluno_ids;
use \report_distance\models\course_id;
use \report_distance\models\log_buffer;
use \report_distance\models\minified_log;
use \report_distance\models\transational_distance;

class report_distance_miner
{
	public function __construct() {}

	public function init() 
	{
		global $DB;

		$DB->delete_records(transational_distance::table);

		return $this;
	}

	public function populate_students()
	{
		$this->populate(student::class);

		return $this;
	}

	public function populate_teachers()
	{
		$this->populate(teacher::class);

		return $this;
	}

	public function populate_posts()
	{
		$this->populate(post::class);

		return $this;
	}

	public function populate_base($course_id)
	{
		$this->populate(basis::class, $course_id, basis::handler($course_id));

		return $this;
	}

	public function populate_disciplines($course_id)
	{
		$this->populate(discipline::class, $course_id);

		return $this;
	}

	public function populate_alunos_ids($course_id)
	{
		$this->populate(aluno_ids::class, $course_id);

		return $this;
	}

	// TODO course_id ainda não existe
	public function populate_course_ids($course_id)
	{
		$this->populate(course_id::class, $course_id);

		return $this;
	}

	// TODO log_reduzido ainda não existe
	public function populate_log_reduzido($course_id)
	{
		$this->populate(log_buffer::class, $course_id);
		$this->populate(minified_log::class, $course_id);

		return $this;
	}

	public function populate_transational_distance($course_id)
	{
		$this->populate(transational_distance::class, $course_id);

		return $this;
	}

	public function purge_temp_data()
	{
		global $DB;

		$DB->delete_records(basis::table);
		$DB->delete_records(discipline::table);
		$DB->delete_records(student::table);
		$DB->delete_records(post::table);
		$DB->delete_records(teacher::table);
		$DB->delete_records(aluno_ids::table);
		$DB->delete_records(course_id::table);
		$DB->delete_records(log_buffer::table);
		$DB->delete_records(minified_log::table);

		return $this;
	}

	private function populate($model, $course_id = null, $handler = null)
	{
		global $DB;

		if (isset($course_id)) {
			// TODO  the references to the same value should be
			// replaced for something more elegant in the future
			$rs = $DB->get_recordset_sql($model::get, [$course_id, $course_id, $course_id, $course_id]);
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

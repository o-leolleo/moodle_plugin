<?php

use \local_distance\models\basis;
use \local_distance\models\discipline;
use \local_distance\models\student;
use \local_distance\models\post;
use \local_distance\models\teacher;
use \local_distance\models\aluno_ids;
use \local_distance\models\course_id;
use \local_distance\models\log_buffer;
use \local_distance\models\minified_log;
use \local_distance\models\transational_distance;
use \local_distance\models\mdl_course_categories;

class local_distance_miner
{
	private $chunk_size = 10000;

	public function __construct() {}

	public function init()
	{
		global $DB;

		echo "booting...\n";
		$DB->delete_records(transational_distance::table);
		$this->purge_temp_data();

		return $this;
	}

	public function mine()
	{
		$course_ids = mdl_course_categories::get_course_list();

		// shared tables (should be views, but...)
		echo "mounting students...<br>".PHP_EOL;
		$this->populate_students();

		echo "mounting teachers...<br>".PHP_EOL;
		$this->populate_teachers();

		echo "mounting posts...<br>".PHP_EOL;
		$this->populate_posts();

		foreach($course_ids as $id) {
			try {
				// specific tables (should be views, but...)
				echo "STARTING FOR $id...<br>".PHP_EOL;
				echo "mounting basis...<br>".PHP_EOL;
				$this->populate_base($id);

				echo "mounting disciplines...<br>".PHP_EOL;
				$this->populate_disciplines($id);

				echo "mounting aluno_ids...<br>".PHP_EOL;
				$this->populate_alunos_ids($id);

				echo "mounting id_disciplinas...<br>".PHP_EOL;
				$this->populate_course_ids($id);

				echo "populating the fucking log...<br>".PHP_EOL;
				$this->populate_log_reduzido($id);

				echo "calculating transational distance...<br>".PHP_EOL;
				$this->populate_transational_distance($id);
			}
			catch (dml_read_exception $e) {
				cli_problem($e->debuginfo);
			}
			finally {
				echo "DONE!<br>".PHP_EOL;
			}
		}

		echo "cleaning temporary data...<br>".PHP_EOL;
		$this->purge_temp_data();

		echo "FINISH.<br>".PHP_EOL;
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

	public function populate_course_ids($course_id)
	{
		$this->populate(course_id::class, $course_id);

		return $this;
	}

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
			$rs = $DB->get_recordset_sql($model::get, [$course_id, $course_id, $course_id]);
		}
		else {
			$rs = $DB->get_recordset_sql($model::get);
		}

		// chunk size buffer
		$buffer = [];

		foreach ($rs as $record) {
			if (isset($handler)) {
				$record = $handler($record);
			}

			$buffer[] = $record;

			if (count($buffer) >= $this->chunk_size) {
				echo "\tclearing buffer...<br>".PHP_EOL;
				$this->store_results($model::table, $buffer);
			}
		}

		if (count($buffer)) {
			echo "\tclearing buffer...<br>".PHP_EOL;
			$this->store_results($model::table, $buffer);
		}

		$rs->close();
	}

	private function store_results($table, &$buffer)
	{
		global $DB;

		try {
			$DB->insert_records($table, $buffer);
		}
		catch (dml_write_exception $e) {
			cli_problem($e->debuginfo);
		}
		finally {
			$buffer = [];
		}
	}
}

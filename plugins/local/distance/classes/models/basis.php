<?php
namespace local_distance\models;

use DateTime;

class basis
{
	const table = "basis";

	const get = "
		SELECT
			course.id AS course_id,
			course.name AS 'curso',
			semester.name AS 'semestre',
			discipline.fullname AS 'disciplina_nome',
			discipline.id  AS 'disciplina_id',
			discipline.startdate AS 'data_inicio',
			participant.id AS 'aluno_id',
			CONCAT(participant.firstname, ' ',participant.lastname) AS 'aluno_nome'
		FROM {course} discipline
			INNER JOIN  {course_categories} semester  ON (discipline.category = semester.id)
			INNER JOIN  {course_categories} course ON (course.id = semester.parent)
			INNER JOIN  {enrol} enrol ON (enrol.courseid = discipline.id)
			INNER JOIN  {user_enrolments} user_enrolments ON  (user_enrolments.enrolid = enrol.id)
			INNER JOIN  {user} participant  ON  (participant.id = user_enrolments.userid)
			INNER JOIN  {role_assignments} rs  ON  (rs.userid = participant.id)
			INNER JOIN  {context} e  ON  (e.id = rs.contextid AND discipline.id = e.instanceid)
		WHERE
			course.id = ? AND
			e.contextlevel = 50 AND
			rs.roleid = 5
		ORDER BY
			curso,
			semestre,
			disciplina_id,
			aluno_nome";

	const min_semester = 'SELECT MIN(name) AS name FROM {course_categories} WHERE parent = ?';

	public static function get_min_semester($courseid)
	{
		global $DB;
		return $DB->get_record_sql(self::min_semester, [ $courseid ]);
	}

	public static function calculate_period($curr_semester, $first_semester)
	{
		$first_year	  = (int) substr($first_semester, 4);
		$first_period = (int) substr($first_semester, -1);
		$curr_year    = (int) substr($curr_semester, 4);
		$curr_period  = (int) substr($curr_semester, -1);

		return ($curr_year - $first_year) * 2 + $curr_period - $first_period + 1;
	}

	public static function calculate_end_date($semester)
	{
		$year = substr($semester, 4);
		$period = substr($semester, -1);

		$dateString = $period == 1 ? $year."-06-30" : $year."-12-31";

		return (new Datetime($dateString))->getTimestamp();
	}

	public static function handle_semester($semester)
	{
		return substr(preg_replace('/\s+/',' ', $semester), -6);
	}

	public static function handler($course_id)
	{
		$first_semester = self::get_min_semester($course_id);
		$first_semester->name = self::handle_semester($first_semester->name);

		return function($record) use ($first_semester) {
			$record->semestre = self::handle_semester($record->semestre);
			$record->periodo  = self::calculate_period($record->semestre, $first_semester->name);
			$record->data_fim = self::calculate_end_date($record->semestre, $record->periodo);

			return $record;
		};
	}
}

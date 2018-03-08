<?php

class report_distance_miner
{
	private $sqlSample = ' SELECT '.
			' course.name AS \'curso\', '.
			//' HANDLE_SEMESTER(semester.name) AS \'semestre\', ',
			//' CALCULATE_PERIOD( ', @first_semester, ',HANDLE_SEMESTER(semester.name)) AS \'periodo\',',
			' discipline.fullname AS \'disciplina_nome\', '.
			' discipline.id  AS \'disciplina_id\', '.
			' discipline.startdate AS \'data_inicio\', '.
			//' CALCULATE_END_DATE(HANDLE_SEMESTER(semester.name))   AS \'data_fim\', ',
			' participant.id AS \'aluno_id\', '.
			//' REMOVE_DOTS(DELETE_DOUBLE_SPACES(UCASE(CONCAT(participant.firstname, \' \',participant.lastname)))) AS \'aluno_nome\' ',
		' FROM '.
			' {course} discipline '.
				' INNER JOIN '.
					' {course_categories} semester '.
				' ON '.
					' (discipline.category = semester.id) '.
				' INNER JOIN '.
					' {course_categories} course '.
				' ON '.
					' (course.id = semester.parent) '.
				' INNER JOIN '.
					' {enrol} enrol '.
				' ON '.
					' (enrol.courseid = discipline.id) '.
				' INNER JOIN '.
					' {user_enrolments} user_enrolments '.
				' ON '.
					' (user_enrolments.enrolid = enrol.id) '.
				' INNER JOIN '.
					' {user} participant '.
				' ON '.
					' (participant.id = user_enrolments.userid) '.
				' INNER JOIN '.
					' {role_assignments} rs '.
				' ON '.
					' (rs.userid = participant.id) '.
				' INNER JOIN '.
					' {context} e '.
				' ON '.
					' (e.id = rs.contextid AND discipline.id = e.instanceid) '.
		' WHERE '.
			' course.id = ? AND'.
			' e.contextlevel = 50 AND '.
			' rs.roleid = 5 '.
		' ORDER BY '.
			' curso, '.
			' semestre, '.
			' periodo, '.
			' disciplina_id, '.
			' aluno_nome ';

	public function __construct() 
	{

	}

	public function getQuery() 
	{
		return $this->sqlSample;
	}
}

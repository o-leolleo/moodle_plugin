<?php
namespace report_distance\models;

class log_buffer
{
	const table = "log_reduzido";

	// TODO verificar se estes últimos
	// campos estão repetidos
	const get = "
		SELECT
			id,
			timecreated `time`,
			userid,
			courseid `course_id`,
			component,
			action,
			ip,
			objectid `cmid`
		FROM {logstore_standard_log}
		WHERE courseid
		IN (
			SELECT disciplina_id FROM {".course_id::table."} WHERE course_id = ?
		)
		AND userid
		IN (
			SELECT aluno_id FROM {".aluno_ids::table."} WHERE course_id = ?
		)
		UNION
		SELECT
			id,
			timecreated,
			userid,
			courseid `course_id`,
			component,
			action,
			ip,
			objectid `cmid`
		FROM {logstore_standard_log}
		WHERE action='loggedout'
		AND userid IN (
			SELECT aluno_id FROM {".aluno_ids::table."} WHERE course_id = ?
		)
		UNION
		SELECT
			id,
			timecreated,
			userid,
			courseid `course_id`,
			component,
			action,
			ip,
			objectid `cmid`
		FROM {logstore_standard_log}
		WHERE action='loggedin'
		AND userid IN (
			SELECT aluno_id FROM {".aluno_ids::table."} WHERE course_id = ?
		)";

	const purge = "DELTE FROM {".self::table."}";
}

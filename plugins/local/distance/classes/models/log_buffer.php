<?php
namespace local_distance\models;

class log_buffer
{
	const table = "log_reduzido";

	// TODO verificar se estes últimos
	// campos estão repetidos
	// TODO retirar a utilização de TRIM
	const get = "
		SELECT
			id,
			timecreated `time`,
			userid,
			courseid `course`,
			? `course_id`,
			TRIM(LEADING 'mod_' FROM component) `module`,
			action,
			ip,
			objectid `cmid`
		FROM {logstore_standard_log}
		WHERE (
			action='loggedout' OR
			action='loggedin' OR
			courseid IN (
				SELECT disciplina_id FROM {".course_id::table."} WHERE course_id = ?
			)
		)
		AND userid IN (
			SELECT aluno_id FROM {".aluno_ids::table."} WHERE course_id = ?
		)
	";
}

<?php
namespace report_distance\models;

class course_id
{
	const table = "id_disciplinas";

	const get = "
		SELECT DISTINCT(disciplina_id), course_id
		FROM {".basis::table."}
		WHERE course_id = ?";

	const purge = "DELETE FROM {".self::table."}";
}

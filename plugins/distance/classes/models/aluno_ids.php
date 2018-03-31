<?php
namespace report_distance\models;

class aluno_ids
{
	const table = "id_alunos";

	const get = "
		SELECT DISTINCT(aluno_id), course_id
		FROM {".basis::table."}
		WHERE course_id = ? ";

	const purge = "DELETE FROM {".self::table."}";
}

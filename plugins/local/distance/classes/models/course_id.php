<?php
namespace local_distance\models;

class course_id
{
	const table = "id_disciplinas";

	const get = "
		SELECT DISTINCT(disciplina_id), course_id
		FROM {".basis::table."}
		WHERE course_id = ?"; 
}

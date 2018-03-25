<?php 
namespace report_distance\models; 

class discipline
{
	const table = "disciplinas";

	const get = " 
		SELECT DISTINCT (disciplina_id), 
			course_id,
			data_inicio, 
			data_fim 
		FROM {basis} 
		WHERE course_id = ?
		ORDER BY disciplina_id";
}

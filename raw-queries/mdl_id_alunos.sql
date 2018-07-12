SELECT DISTINCT (disciplina_id),
	course_id,
	data_inicio,
	data_fim
FROM mdl_basis
WHERE course_id = 13
ORDER BY disciplina_id

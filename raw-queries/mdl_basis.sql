SELECT
	course.id AS course_id,
	course.name AS 'curso',
	semester.name AS 'semestre',
	discipline.fullname AS 'disciplina_nome',
	discipline.id  AS 'disciplina_id',
	discipline.startdate AS 'data_inicio',
	discipline.enddate AS 'data_fim',
	participant.id AS 'aluno_id',
	CONCAT(participant.firstname, ' ',participant.lastname) AS 'aluno_nome'
FROM mdl_course discipline
	INNER JOIN  mdl_course_categories semester  ON (discipline.category = semester.id)
	INNER JOIN  mdl_course_categories course ON (course.id = semester.parent)
	INNER JOIN  mdl_enrol enrol ON (enrol.courseid = discipline.id)
	INNER JOIN  mdl_user_enrolments user_enrolments ON  (user_enrolments.enrolid = enrol.id)
	INNER JOIN  mdl_user participant  ON  (participant.id = user_enrolments.userid)
	INNER JOIN  mdl_role_assignments rs  ON  (rs.userid = participant.id)
	INNER JOIN  mdl_context e  ON  (e.id = rs.contextid AND discipline.id = e.instanceid)
WHERE
	course.id = ? AND
	e.contextlevel = 50 AND
	rs.roleid = 5
ORDER BY
	curso,
	semestre,
	disciplina_id,
	aluno_nome";

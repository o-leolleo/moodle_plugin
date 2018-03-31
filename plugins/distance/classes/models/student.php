<?php
namespace report_distance\models; 

class student
{
	const table = "alunos";

	const get = "
		SELECT c.id AS 'disciplina_id', u.id AS 'aluno_id'
		FROM mdl_role_assignments rs
		INNER JOIN mdl_context e ON rs.contextid=e.id
		INNER JOIN mdl_course c ON c.id = e.instanceid
		INNER JOIN mdl_user u ON u.id=rs.userid
		WHERE e.contextlevel=50 AND rs.roleid=5
		ORDER BY c.id, u.id";

	const purge = "DELETE FROM {".self::table."}";
}

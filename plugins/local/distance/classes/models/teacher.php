<?php
namespace local_distance\models;

class teacher
{
	const table = "professores";

	const get = " 
		SELECT DISTINCT c.id AS 'disciplina_id', u.id AS 'professor_id'
		FROM mdl_role_assignments rs 
		INNER JOIN mdl_context e ON rs.contextid=e.id 
		INNER JOIN mdl_course c ON c.id = e.instanceid 
		INNER JOIN mdl_user u ON u.id=rs.userid 
		WHERE e.contextlevel=50 AND rs.roleid IN (3,4,10,20,21)
		ORDER BY c.id, u.id";
}

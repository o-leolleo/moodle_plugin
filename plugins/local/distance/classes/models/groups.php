<?php
namespace local_distance\models;

class groups
{
	const of_course = "
		SELECT id, courseid, name
		FROM {groups} g
		WHERE courseid = ?
	";

	const get_students_in_discipline = "
		SELECT td.aluno_id, td.aluno_nome
		FROM {groups_members} gm
		INNER JOIN {".transational_distance::table."} td
		ON td.aluno_id = gm.userid
		WHERE gm.groupid = ? AND td.disciplina_id = ?
	";

	const get_students = "
		SELECT td.aluno_id, td.aluno_nome
		FROM {groups_members} gm
		INNER JOIN {".transational_distance::table."} td
		ON td.aluno_id = gm.userid
		WHERE gm.groupid = ?
	";
}

<?php
namespace report_distance\models;

class aluno_ids
{
	const table = "aluno_ids";

	const get = "
		SELECT DISTINCT(aluno_id)
		FROM {basis}";
}

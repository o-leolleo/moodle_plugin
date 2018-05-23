<?php
namespace local_distance\models;

class post
{
	const table = "posts";

	const update = "
		INSERT INTO {".self::table."} (
			disciplina_id, 
			data, 
			nome_forum, 
			post, 
			parent,
			emissor,
			receptor
		) 
		SELECT
			fd.course AS 'disciplina_id',
			p2.created AS 'data',
			f.name AS 'nome_forum',
			p2.id AS 'post',
			p2.parent,
			p2.userid AS 'emissor',
			p1.userid AS 'receptor'
		FROM mdl_forum_posts p1
		INNER JOIN mdl_forum_posts p2 ON  p1.id=p2.parent
		INNER JOIN mdl_forum_discussions fd ON p1.discussion=fd.id
		INNER JOIN mdl_forum f ON fd.forum=f.id
	";
}

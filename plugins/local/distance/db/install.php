<?php
use local_distance\models\mdl_course_categories;

function xmldb_local_distance_install()
{
	echo "booting...\n";

	$course_ids = mdl_course_categories::get_course_list();
	$miner = (new local_distance_miner())->init();

	// shared tables (should be views, but...)
	echo "mounting students...\n";
	$miner->populate_students();

	echo "mounting teachers...\n";
	$miner->populate_teachers();

	echo "mounting posts...\n";
	$miner->populate_posts();

	foreach($course_ids as $id) {
		try {
			// specific tables (should be views, but...)
			echo "STARTING FOR $id...\n";
			echo "mounting basis...\n";
			$miner->populate_base($id);

			echo "mounting disciplines...\n";
			$miner->populate_disciplines($id);

			echo "mounting aluno_ids...\n";
			$miner->populate_alunos_ids($id);

			echo "mounting id_disciplinas...\n";
			$miner->populate_course_ids($id);

			echo "populating the fucking log...\n";
			$miner->populate_log_reduzido($id);

			echo "calculating transational distance...\n";
			$miner->populate_transational_distance($id);
		}
		catch (dml_read_exception $e) {
			cli_problem($e->debuginfo);
		}
		finally {
			echo "DONE!\n";
		}
	}

	echo "cleaning temporary data...\n";
	$miner->purge_temp_data();

	echo "FINISH.\n";

	return true;
}

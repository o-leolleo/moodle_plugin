<?php
use local_distance\job\miner;

function xmldb_local_distance_upgrade($oldversion)
{
	global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

	if ($oldversion < 2018021468) {
		// Define field var19 to be added to transational_distance.
		$table = new xmldb_table('transational_distance');

		$field = new xmldb_field('var19', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'var18');

		// Conditionally launch add field var19.
		if (!$dbman->field_exists($table, $field)) {
			$dbman->add_field($table, $field);
		}

		// Define field var21 to be added to transational_distance.
		$field = new xmldb_field('var21', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'var19');

		// Conditionally launch add field var21.
		if (!$dbman->field_exists($table, $field)) {
			$dbman->add_field($table, $field);
		}

		// Define field var22 to be added to transational_distance.
		$field = new xmldb_field('var22', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'var21');

		// Conditionally launch add field var22.
		if (!$dbman->field_exists($table, $field)) {
			$dbman->add_field($table, $field);
		}

		// Distance savepoint reached.
		upgrade_plugin_savepoint(true, 2018021467, 'report', 'distance');
	}

	return true;
}

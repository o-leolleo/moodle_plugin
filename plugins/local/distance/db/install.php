<?php

function xmldb_local_distance_install()
{
	(new local_distance_miner())->init()->mine();
}

// TODO deve executar, porém
// ainda não foi testado
//xmldb_local_distance_install();

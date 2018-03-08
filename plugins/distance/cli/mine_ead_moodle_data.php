<?php
define('CLI_SCRIPT', true);
require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../classes/miner.php');
require_once(__DIR__.'/../classes/constant/query.php');
require_once($CFG->libdir.'/clilib.php');

$report = new report_distance_miner();
cli_writeln($report->create_base('alunos_semestre_adm_publica'));

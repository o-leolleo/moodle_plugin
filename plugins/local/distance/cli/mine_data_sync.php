<?php
// This is a fake CLI script, it is a really ugly hack which emulates
// CLI via web interface, please do not use this hack elsewhere
define('CLI_SCRIPT', true);
define('WEB_CRON_EMULATED_CLI', 'defined'); // ugly ugly hack, do not use elsewhere please
define('NO_OUTPUT_BUFFERING', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');

// extra safety
\core\session\manager::write_close();

// This script is being called via the web, so check the password if there is one.
if (!empty($CFG->cronremotepassword)) {
    $pass = optional_param('password', '', PARAM_RAW);
    if ($pass != $CFG->cronremotepassword) {
        // wrong password.
        print_error('cronerrorpassword', 'admin');
        exit;
    }
}

// send mime type and encoding
@header('Content-Type: text/plain; charset=utf-8');

// we do not want html markup in emulated CLI
@ini_set('html_errors', 'off');
@ini_set('max_execution_time', 6000);

$miner = new local_distance_miner();
$miner->init()->mine();

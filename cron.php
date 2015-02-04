<?php

require_once('config.php');
require_once('solusvm.php');

if ($_GET['p'] != $password)
	die('wrong password');

ignore_user_abort(TRUE);
set_time_limit(0);

$success = TRUE;
foreach ($api as $key => $value) {
	$ret = solusvm($value, 'boot');
	if ($ret['status'] != 'success')
		$success = FALSE;
}

echo ($success ? 'ok' : 'fail');

<?php

require_once('config.php');
require_once('solusvm.php');

$name = $_GET['name'];
if (!isset($api[$name])) {
	die(header('Location: http://du9l.com', TRUE, 302));
}
$vpsapi = $api[$name];
$showname = htmlspecialchars($name);
$urlname = urlencode($name);

$action = $_GET['act'];
if (!$action) {
	// show vps status
	echo "<h1>{$showname} status</h1>";
	$flags = array('hdd' => 'true', 'mem' => 'true', 'bw' => 'true');
	$ret = solusvm($vpsapi, 'info', TRUE, $flags);
	print_table($ret);
	echo "<p><a href=\"/?name={$urlname}&act=boot\">boot</a></p>";
} else if ($action == 'boot') {
	// boot vps
	echo "<h1>{$showname} boot</h1>";
	$ret = solusvm($vpsapi, 'boot', TRUE);
	print_table($ret);
	echo "<p><a href=\"/?name={$urlname}\">status</a></p>";
} else {
	die(header('Location: http://du9l.com', TRUE, 302));
}

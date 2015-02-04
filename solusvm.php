<?php

function solusvm($api, $action, $status = FALSE, $extra = NULL) {
	$url = 'https://' . $api['host'] . ':5656/api/client/command.php';
	$postfields = array(
		'key' => $api['key'],
		'hash' => $api['hash'],
		'action' => $action,
	);
	if ($status) {
		$postfields['status'] = 'true';
	}

	$usedkeys = array_keys($postfields);
	if (is_array($extra)) {
		foreach ($extra as $key => $value) {
			$k = strtolower($key);
			if (!in_array($key, $usedkeys)) {
				$postfields[$key] = $value;
			}
		}
	}

	// send request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect: "));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);

	// parse response
	preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $match);
	$result = array();
	foreach ($match[1] as $x => $y)
	{
		$result[$y] = $match[2][$x];
	}

	return $result;
}

function match_array($text) {
	$pattern = '/^(\d+),(\d+),(\d+),(\d+)$/';
	if (preg_match($pattern, $text, $matches) === 0) {
		return FALSE;
	} else {
		return $matches;
	}
}

function auto_size($text) {
	$i = intval($text);
	$k = 1024;
	$m = $k * 1024;
	$g = $m * 1024;
	$t = $g * 1024;
	if ($i >= $t) {
		return number_format($i / $t, 3) . ' TiB';
	} else if ($i >= $g) {
		return number_format($i / $g, 3) . ' GiB';
	} else if ($i >= $m) {
		return number_format($i / $m, 3) . ' MiB';
	} else if ($i >= $k) {
		return number_format($i / $k, 3) . ' KiB';
	} else {
		return number_format($i, 3) . ' B';
	}
}

function print_table($array) {
	echo '<table>';
	foreach ($array as $key => $value) {
		echo '<tr><td><b>' . htmlspecialchars($key) . '</b></td>';
		$try_match = match_array($value);
		if ($try_match === FALSE) {
			echo '<td>' . htmlspecialchars($value) . '</td></tr>';
		} else {
			echo '<td>Total: ' . auto_size($try_match[1]) .
				'; Used: ' . auto_size($try_match[2]) . ' (' . $try_match[4] .
				'%); Free: ' . auto_size($try_match[3]) . '</td></tr>';
		}
	}
	echo '</table>';
}

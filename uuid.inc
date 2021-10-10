<?php

/*
 * UUID utils for PHP
 * Copyright 2011 - 2021 Daniel Marschall, ViaThinkSoft
 * Version 2021-05-21
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
# This library requires either the GMP extension (or BCMath if gmp_supplement.inc.php is present)

/* modified 2021 by @HankLloydRight for Pluto m3u generation
   only one function was needed and modified below to accept the MAC address as a function parameter
*/

function gen_uuid_timebased($mac) {
	# If we hadn't any success yet, then implement the time based generation routine ourselves!
	# Based on https://github.com/fredriklindberg/class.uuid.php/blob/master/class.uuid.php
	$uuid = array(
		'time_low' => 0,		/* 32-bit */
		'time_mid' => 0,		/* 16-bit */
		'time_hi' => 0,			/* 16-bit */
		'clock_seq_hi' => 0,		/*  8-bit */
		'clock_seq_low' => 0,		/*  8-bit */
		'node' => array()		/* 48-bit */
	);

	/*
	 * Get current time in 100 ns intervals. The magic value
	 * is the offset between UNIX epoch and the UUID UTC
	 * time base October 15, 1582.
	 */
	$tp = gettimeofday();
	$time = ($tp['sec'] * 10000000) + ($tp['usec'] * 10) + 0x01B21DD213814000;

	$uuid['time_low'] = $time & 0xffffffff;
	/* Work around PHP 32-bit bit-operation limits */
	$high = intval($time / 0xffffffff);
	$uuid['time_mid'] = $high & 0xffff;
	$uuid['time_hi'] = (($high >> 16) & 0xfff) | (1/*TimeBased*/ << 12);

	/*
	 * We don't support saved state information and generate
	 * a random clock sequence each time.
	 */
	$uuid['clock_seq_hi'] = 0x80 | mt_rand(0, 64);
	$uuid['clock_seq_low'] = mt_rand(0, 255);

	/*
	 * Node should be set to the 48-bit IEEE node identifier
	 */
	if ($mac) {
		$node = str_replace(':','',$mac);
		for ($i = 0; $i < 6; $i++) {
			$uuid['node'][$i] = hexdec(substr($node, $i*2, 2));
		}

		/*
		 * Now output the UUID
		 */
		return sprintf(
			'%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
			($uuid['time_low']), ($uuid['time_mid']), ($uuid['time_hi']),
			$uuid['clock_seq_hi'], $uuid['clock_seq_low'],
			$uuid['node'][0], $uuid['node'][1], $uuid['node'][2],
			$uuid['node'][3], $uuid['node'][4], $uuid['node'][5]);
	}

	# We cannot generate the timebased UUID!
	return false;
}

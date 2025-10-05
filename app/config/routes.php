<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'UsersController::index');
$router->match('/users/create', 'UsersController::create', ['GET', 'POST']);
$router->match('/users/update/{id}', 'UsersController::update', ['GET', 'POST']);
$router->get('/users/delete/{id}', 'UsersController::delete');
// Admin panel
$router->get('/admin', 'AdminController::index');
$router->match('/admin/set_role/{id}', 'AdminController::set_role', ['POST']);

// Authentication
$router->match('/auth/login', 'AuthController::login', ['GET', 'POST']);
$router->get('/auth/logout', 'AuthController::logout');
$router->match('/auth/register', 'AuthController::register', ['GET', 'POST']);

// Temporary debug route - remove after troubleshooting
$router->get('/__debug_router', function() {
	header('Content-Type: text/plain');
	$vars = [
		'REQUEST_URI' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
		'SCRIPT_NAME' => isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '',
		'PATH_INFO' => isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '',
		'PHP_SELF' => isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '',
		'SCRIPT_FILENAME' => isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '',
	];
	foreach ($vars as $k => $v) {
		echo $k . ': ' . $v . "\n";
	}
});

// Aliases for servers that include index.php in the URL (some hosts)
$router->match('/index.php', 'UsersController::index', ['GET']);
$router->match('/index.php/', 'UsersController::index', ['GET']);
$router->match('/index.php/auth/login', 'AuthController::login', ['GET', 'POST']);
$router->match('/index.php/auth/register', 'AuthController::register', ['GET', 'POST']);
$router->get('/index.php/auth/logout', 'AuthController::logout');

// Temporary admin check route - remove after troubleshooting
$router->get('/__admin_check', function() {
	header('Content-Type: text/plain');
	echo "Admin check report\n\n";
	try {
		$db = new Database();
		// Show columns
		$cols = $db->raw("SHOW COLUMNS FROM students")->fetchAll(PDO::FETCH_ASSOC);
		$fields = array_map(function($r){ return $r['Field']; }, $cols);
		echo "Columns: " . implode(',', $fields) . "\n\n";

		// Check for the configured admin email and list any other admins
		$stmt = $db->raw("SELECT id,email,role, LENGTH(password) AS password_len FROM students WHERE email = 'colasito@admin'");
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (empty($rows)) {
			echo "No admin row found for email 'colasito@admin'.\n";
		} else {
			foreach ($rows as $r) {
				echo "Primary admin -> id: {$r['id']}, email: {$r['email']}, role: {$r['role']}, password_len: {$r['password_len']}\n";
			}
		}

		// Also list any other accounts that currently have role = 'admin'
	$stmt2 = $db->raw("SELECT id,email,role FROM students WHERE role = 'admin' AND email <> 'colasito@admin'");
		$others = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($others)) {
			echo "\nOther admin accounts found (should be none):\n";
			foreach ($others as $o) {
				echo "id: {$o['id']}, email: {$o['email']}, role: {$o['role']}\n";
			}
		} else {
			echo "\nNo other admin accounts found.\n";
		}
	} catch (Exception $e) {
		echo "Error: " . $e->getMessage() . "\n";
	}
});

// Environment debug route - temporary, remove after troubleshooting
$router->get('/__env_debug', function() {
	header('Content-Type: text/plain');
	echo "Environment debug report\n\n";
	echo "PHP Version: " . PHP_VERSION . "\n";
	echo "Server Software: " . (isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'n/a') . "\n\n";

	// Session paths
	$sess_ini = ini_get('session.save_path');
	echo "session.save_path (ini): " . ($sess_ini ?: '(empty)') . "\n";
	$app_sess = isset($GLOBALS['config']['sess_save_path']) ? $GLOBALS['config']['sess_save_path'] : '';
	echo "app config sess_save_path: " . ($app_sess ?: '(empty)') . "\n";

	$runtime = realpath(__DIR__ . '/../../runtime');
	echo "runtime path: " . ($runtime ?: '(not found)') . "\n";
	$sess_dir = $runtime ? $runtime . '/sessions' : null;
	$logs_dir = $runtime ? $runtime . '/logs' : null;
	echo "runtime/sessions exists: " . ($sess_dir && is_dir($sess_dir) ? 'yes' : 'no') . "\n";
	echo "runtime/logs exists: " . ($logs_dir && is_dir($logs_dir) ? 'yes' : 'no') . "\n";
	if ($sess_dir) echo "runtime/sessions writable: " . (is_writable($sess_dir) ? 'yes' : 'no') . "\n";
	if ($logs_dir) echo "runtime/logs writable: " . (is_writable($logs_dir) ? 'yes' : 'no') . "\n";

	// auth_debug log (if present in either runtime/logs or sys temp)
	$candidates = [];
	if ($logs_dir) $candidates[] = $logs_dir . '/auth_debug.log';
	$candidates[] = sys_get_temp_dir() . '/auth_debug.log';
	foreach ($candidates as $p) {
		if (file_exists($p)) {
			echo "\nFound auth debug log at: $p\n";
			$lines = @file($p, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			if ($lines) {
				$tail = array_slice($lines, -30);
				echo "--- last lines ---\n";
				foreach ($tail as $l) echo $l . "\n";
				echo "--- end ---\n";
			} else {
				echo "(log empty)\n";
			}
			break;
		}
	}

	// DB check - count admin rows
	try {
		$db = new Database();
		$stmt = $db->raw("SELECT COUNT(*) AS cnt FROM students WHERE email = 'colasito@admin'");
		$r = $stmt->fetch(PDO::FETCH_ASSOC);
		echo "\nDB: colasito@admin rows: " . ($r['cnt'] ?? 'n/a') . "\n";
		$stmt2 = $db->raw("SELECT id,email,role,LENGTH(password) AS password_len FROM students WHERE role = 'admin' LIMIT 20");
		$rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		echo "Admin accounts (up to 20):\n";
		foreach ($rows as $row) {
			echo "id: {$row['id']}, email: {$row['email']}, role: {$row['role']}, password_len: {$row['password_len']}\n";
		}
	} catch (Exception $e) {
		echo "DB check error: " . $e->getMessage() . "\n";
	}
	echo "\nEnd of report\n";
});

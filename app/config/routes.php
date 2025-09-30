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

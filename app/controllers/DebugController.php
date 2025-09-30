<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class DebugController extends Controller {
    public function show404()
    {
        header('Content-Type: text/plain');
        echo "404 override - debug\n\n";
        echo "REQUEST_URI: " . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') . "\n";
        echo "SCRIPT_NAME: " . (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '') . "\n";
        echo "PATH_INFO: " . (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '') . "\n";
        echo "PHP_SELF: " . (isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '') . "\n";
        echo "SCRIPT_FILENAME: " . (isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '') . "\n";
        echo "QUERY_STRING: " . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '') . "\n";
        echo "HTTP_HOST: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . "\n";

        echo "\n--- GET params ---\n";
        print_r($_GET);

        echo "\n--- SERVER ---\n";
        $server_keys = ['REQUEST_METHOD','REQUEST_URI','PATH_INFO','PHP_SELF','SCRIPT_NAME','SCRIPT_FILENAME','QUERY_STRING','HTTP_HOST','SERVER_SOFTWARE','HTTP_USER_AGENT'];
        foreach ($server_keys as $k) {
            if (isset($_SERVER[$k])) echo "$k: " . $_SERVER[$k] . "\n";
        }
    }
}

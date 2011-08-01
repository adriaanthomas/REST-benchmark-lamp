<?php
include('RestServer.php');
include('RestController.php');

spl_autoload_register(); // don't load our classes unless we use them

$mode = 'debug'; // 'debug' or 'production'
$server = new RestServer($mode);
// $server->refreshCache(); // uncomment momentarily to clear the cache if classes change in production mode

$server->addClass('RestController', '/~adriaan');
// $server->addClass('ProductsController', '/products'); // adds this as a base to all the URLs in this class

//echo 'about to call handle.';
$server->handle();
?>

<?php
require "vendor/autoload.php";

$lxdSocketResolver = new LxdSocketResolver();

$bindAddress = '127.100.1.1';

echo 'dns server starting on interface ' . $bindAddress . PHP_EOL;
$dns = new yswery\DNS\Server($lxdSocketResolver, $bindAddress);
$dns->start();
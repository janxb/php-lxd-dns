<?php
require "vendor/autoload.php";

$recursiveProvider = new yswery\DNS\RecursiveProvider();
$lxdSocketResolver = new LxdSocketResolver();

$stackableResolver = new yswery\DNS\StackableResolver(array($lxdSocketResolver, $recursiveProvider));

$dns = new yswery\DNS\Server($stackableResolver, '127.100.1.1');
$dns->start();
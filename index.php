<?php
require "vendor/autoload.php";


// Recursive provider acting as a fallback to the JsonStorageProvider
$recursiveProvider = new yswery\DNS\RecursiveProvider();

// $stackableResolver = new yswery\DNS\StackableResolver(array($jsonStorageProvider, $recursiveProvider));

// Creating a new instance of our class
$dns = new yswery\DNS\Server($recursiveProvider);

// Starting our DNS server
$dns->start();
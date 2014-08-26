<?php

$it = new RecursiveDirectoryIterator(".");
$it = new RecursiveIteratorIterator($it);
foreach ($it as $k => $v) {
    print $v->getPathname()." => ".$v->getSize()."\n";
}


<?php

$it = new RecursiveDirectoryIterator("/home/jthijssen/redis-2.8.9");
$it2 = new RecursiveIteratorIterator($it);

// Get everything matching "lua"
$it3_1 = new RegexIterator($it2, "/lua/");

//Get everything above 102400 bytes
$it3_2 = new CallbackFilterIterator($it2, function ($f) { return $f->getSize() > 102400; });

// Get everything with 0 bytes
$it3_3 = new CallbackFilterIterator($it2, function ($f) { return $f->getSize() == 0; });


// Start with empty append-iterator
$it3 = new AppendIterator(new EmptyIterator());

// Add all iterators
$it3->append($it3_1);
$it3->append($it3_2);
$it3->append($it3_3);


foreach ($it3 as $k => $v) {
    print $v->getPathname()." => ".$v->getSize()."\n";
}


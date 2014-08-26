<?php

$it = new ArrayIterator(array('foo','bar','baz'));
foreach ($it as $k => $v) {
    print "$k  => $v\n";
}

print "===\n";

$it = new ArrayIterator(array('foo','bar','baz'));
$it = new LimitIterator($it, 0, 2);
foreach ($it as $k => $v) {
    print "$k  => $v\n";
}


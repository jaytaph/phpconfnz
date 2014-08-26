<?php

$it = new ArrayIterator(array('foo','bar','baz'));
$it = new InfiniteIterator($it);
$it = new LimitIterator($it, 0, 10);
foreach ($it as $k => $v) {
    print "$k  => $v\n";
}


<?php

$stack = new SplStack();
$stack->push("foo");
$stack->push("bar");
$stack->push("baz");

print $stack->pop() . "\n";
print $stack->pop() . "\n";
print $stack->pop() . "\n";



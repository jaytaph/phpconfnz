<?php

$queue = new SplQueue();
$queue->enqueue("foo");
$queue->enqueue("bar");
$queue->enqueue("baz");

print $queue->dequeue() . "\n";
print $queue->dequeue() . "\n";
print $queue->dequeue() . "\n";



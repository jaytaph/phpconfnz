<?php
$f = fopen("test.html", "r");

// Normal read
$html = fread($f, 1024);
print_r($html);

// Add strip-tags filter to the current file
stream_filter_append($f, "string.strip_tags");

// Read again
fseek($f, 0, SEEK_SET);
$html = fread($f, 1024);
print_r($html);

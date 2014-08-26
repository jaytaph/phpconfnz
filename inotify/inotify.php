<?php

$inotify = inotify_init();


inotify_add_watch($inotify, __FILE__, IN_ALL_EVENTS);

$events = inotify_read($inotify);
print_r($events);
SIGUSR1

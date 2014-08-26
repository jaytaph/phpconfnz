<?php

declare(ticks = 1);

function hup_handler() {
    print "signal HUP called()\n";
}

function window_handler() {
    print "Window size has changed.\n";
}

// Act on SIGHUP
pcntl_signal(SIGHUP, "hup_handler");

pcntl_signal(SIGWINCH, "window_handler");

// Don't act on USR1 and USR2
pcntl_signal(SIGUSR1, SIG_IGN);
pcntl_signal(SIGUSR2, SIG_IGN);

print "Try and send signal to process ".posix_getpid()."\n";

while (true) {
    sleep(1);
    print ".";
}

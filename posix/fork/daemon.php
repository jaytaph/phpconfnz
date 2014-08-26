<?php

print "Starting deamon...\n";
daemonize();

// Do "root" stuff, like opening sockets etc here

drop_root();

// Here, we are running as a non-privileged user

while(true) {
    sleep(1);
}
exit();


function daemonize()
{
    $pid = pcntl_fork();
    if ($pid == -1) die ("Error while fork()ing\n");

    if ($pid > 0) {
        // The parent just dies and does nothing
        exit(0);
    }

    # Set this process as session leader
    posix_setsid();

    // Change working directory to root
    chdir("/");

    // Close current STD handles
    fclose(STDIN);
    fclose(STDOUT);
    fclose(STDERR);

    // As no file handles are open, these are automatically opened as FD 0, 1 and 2 respectively
    fopen("/dev/null", "r");
    fopen("/dev/null", "w");
    fopen("/dev/null", "w");
}

function drop_root() {
    // Set effective UID, meaning we don't have any permissions anymore
    posix_seteuid(-1);
    posix_setegid(-1);
}


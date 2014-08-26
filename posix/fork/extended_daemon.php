<?php

// Important to make signals work
declare(ticks = 1);

print "Starting deamon...\n";
daemonize();

// An array with all the PIDS, accessible from the master PID only.
$pids = array();

// Do "root" stuff, like opening sockets etc here

pcntl_signal(SIGCHLD, "child_handler");

drop_root();

// Now, we are running as a non-privileged user

// Spawn 5 children
for ($i=0; $i!=5; $i++) {
    $pids[] = spawn_child(function() {
        while (true) {
            // Do your child stuff here
            sleep(1);
        }
    });
}

// As the master process, we could signal our childs, or do anything we want. Most likely, we just want to wait for
// a terminate singal, at which point we terminate the children first, before exitting.
while(true) {
    print_r($pids);
    sleep(5);
}
exit();


/**
 * Waits for a child to terminate, and update the PID array
 * @param $signo
 */
function child_handler($signo) {
    $pid = pcntl_waitpid(-1, $status, WNOHANG);
    print "Child exited: $pid\n";

    global $pids;
    $k = array_search($pid, $pids);
    unset($pids[$k]);
}


/**
 * Spawns a child and runs the callback in it.
 *
 * @param $cb
 * @return int
 */
function spawn_child($cb) {
    $pid = pcntl_fork();
    if ($pid > 0) return $pid;

    $cb();
    exit(0);
}

/**
 * Daemonizes the application
 */
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
}

/**
 * Drops root privileges so the daemon can run more safely.
 */
function drop_root() {
    // Set effective UID, meaning we don't have any permissions anymore
    posix_seteuid(-1);
    posix_setegid(-1);
}


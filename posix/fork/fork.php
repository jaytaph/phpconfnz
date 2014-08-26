<?php

$res = pcntl_fork();
if ($res == -1) {
    die("Error while fork()ing\n");
}


// Child process
if ($res == 0) {
    print "This is the child process running on pid ".posix_getpid()."\n";

    for ($i=5; $i!=0; $i--) {
        print $i . "\n";
        usleep(100);
        //sleep(1);
    }

    //// Send a kill signal to ourselves to get terminated
    //posix_kill(posix_getpid(), SIGKILL);

    // Or just exit with a certain exit code
    exit(23);

// Parent process
} else {
    print "This is the parent.. The child has spawned into pid ".$res."\n";

    pcntl_waitpid($res, $status);
    $exitcode = pcntl_wexitstatus($status);
    $signalled = pcntl_wifsignaled($status);
    print "Signalled: ".($signalled?"yes":"no")."\n";
    print "Child has ended with code: $exitcode\n";
}

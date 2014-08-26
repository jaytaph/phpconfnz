<?php

$iv = base64_decode($argv[1]);
$key = base64_decode($argv[2]);
$ciphertext = base64_decode($argv[3]);

$plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $ciphertext, MCRYPT_MODE_CBC, $iv);

print "PLAINTEXT: ".$plaintext."\n";


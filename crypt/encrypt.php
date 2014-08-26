<?php

$key = openssl_random_pseudo_bytes(32);

$plaintext = $argv[1];

$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);

$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

print "IV: ".base64_encode($iv)."\n";
print "KEY: ".base64_encode($key)."\n";
print "CIPHER: ".base64_encode($ciphertext)."\n";


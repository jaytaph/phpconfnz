<?php

$safe_hash = password_hash("foobar", PASSWORD_DEFAULT);
print $safe_hash."\n";
// Does this hash "meet" the critera?
var_dump(password_needs_rehash($safe_hash, PASSWORD_DEFAULT, array('cost' => 10)));


$unsafe_hash = password_hash("foobar", PASSWORD_DEFAULT, array('salt' => str_repeat('NaCl', 10), 'cost' => 4));
print $unsafe_hash."\n";
var_dump(password_needs_rehash($unsafe_hash, PASSWORD_DEFAULT, array('cost' => 7)));


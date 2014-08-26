<?php

print hash_hmac('md5', 'foobar', 'secret') . "\n";
print md5('foobar')."\n";

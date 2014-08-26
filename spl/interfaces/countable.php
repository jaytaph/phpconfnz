<?php

class MyClass implements Countable
{

    function __construct(array $items)
    {
        $this->items = $items;
    }

    public function count()
    {
        return count(array_unique($this->items));
    }

}


$myclass = new MyClass([1,1,2,2,3,6,6,6,2,2,1,4]);
print "There are ".count($myclass)." unique items in the class\n";

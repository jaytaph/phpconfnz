<?php

class MyClass implements IteratorAggregate
{

    function __construct(array $items)
    {
        $this->items = $items;
    }

    public function foo()
    {
        print "foo";
    }

    public function bar()
    {
        print "bar";
    }


    /**
     * Returns an iterator
     *
     * @return Traversable
     */
    public function getIterator()
    {
        $it = new ArrayIterator($this->items);
        $it = new LimitIterator($it, 0, 5);
        return $it;
    }

}


$myclass = new MyClass([1,2,3,4,5,6,7,8,9,10]);
foreach ($myclass as $k => $v) {
    print "$k  => $v\n";
}

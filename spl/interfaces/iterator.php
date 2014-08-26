<?php

class FibonacciIterator implements Iterator
{

    protected $num = 1;
    protected $old_num = 0;
    protected $idx = 0;

    // Return current number
    public function current()
    {
        return $this->num;
    }

    // Progress to the next number
    public function next()
    {
        // Increase fibonacci number
        $tmp = $this->num;
        $this->num = $this->num + $this->old_num;
        $this->old_num = $tmp;

        // Increase index
        $this->idx++;
    }

    public function key()
    {
        // Return index as key
        return $this->idx;
    }

    // Returns true when the iterator contains a valid value (through current())
    public function valid()
    {
        // Continue for as long as our fibonacci number is less than maximum php int.
        return $this->num < PHP_INT_MAX;
    }

    // Rewind the iterator back to the beginning.
    public function rewind()
    {
        $this->num = 1;
        $this->old_num = 0;
        $this->idx =0 ;
    }

}

$it = new FibonacciIterator();
foreach ($it as $k => $v) {
    print "$k  => $v\n";
}

<?php

class iniStream {

    // Actual INI data
    protected $ini;

    // Path the the ini file
    protected $path;

    // Actual section we (want to) read
    protected $section;

    // The current position inside the ini array we are reading
    protected $position;


    // Internal function that just parses the "filename" into the path and section, and read corresponding ini file
    protected function readIni($path)
    {
        // Cut "ini://" part and store the file
        $this->path = substr($path, 6);
        $this->section = false;

        if (strpos($this->path, "#") !== false) {
            list($this->path, $this->section) = explode("#", $this->path, 2);
        }

        // Read ini file and process sections
        $this->ini = parse_ini_file($this->path, true);

        // Doesn't seem like an INI file
        if ($this->ini == false) {
            return false;
        }

        // We are looking for a section, but it does not exist.
        if ($this->section && ! isset($this->ini[$this->section])) {
            return false;
        }

        // Reset the ini file to the beginning
        reset($this->ini);

        return true;
    }


    // Opens a INI "directory"
    public function dir_opendir($path, $options)
    {
        return $this->readini($path);
    }

    // Read an element from the current directory handle. This is the same object that called dir_opendir()
    public function dir_readdir()
    {
        // Get a section from the ini
        $section = key($this->ini);

        // No more sections, return false
        if ($section == false) return false;

        // Increase internal array pointer
        next($this->ini);

        // Return "filename" that can read directly the ini section
        return "ini://".$this->path."#".$section;
    }


    // Close directory handle
    public function dir_closedir() {
        return true;
    }

    // Rewind directory
    public function dir_rewinddir() {
        reset($this->ini);
    }



    // Open a section "file" from a ini file
    function stream_open($path, $mode, $options, &$opened_path)
    {
        if (! $this->readini($path)) {
            return false;
        }

        $this->position = 0;
        return true;
    }

    // Read a slice of the json from the section of the ini
    function stream_read($count)
    {
        $json = json_encode($this->ini[$this->section]);

        $max = strlen($json);
        if ($this->position >= $max) return false;

        $slice = substr($json, $this->position, $count);

        $this->position += $count;
        if ($this->position > $max) {
            $this->position = $max;
        }

        return $slice;
    }

    function stream_stat()
    {
        return $this->url_stat("ini://".$this->path.($this->section?"#".$this->section:""), 0);
    }

    // Return true when we have reached the end of our stream
    function stream_eof() {
        $max = count($this->ini[$this->section]);
        return $this->position >= $max;
    }

    function stream_tell()
    {
        return $this->position;
    }


    function url_stat($path, $flags) {
        if (! $this->readini($path)) {
            return false;
        }

        // Stat is the same as the action ini, exception the filesize is the number of elements in the section
        $stat = stat($this->path);
        $stat['size'] = count($this->ini[$this->section]);
        return $stat;
    }
}

stream_wrapper_register("ini", "iniStream") or die("Failed to register protocol");

$it = new DirectoryIterator("ini://php.ini");
foreach ($it as $k => $v) {
    print "$k => $v \n";

    var_dump(file_get_contents($v));
}


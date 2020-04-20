<?php
class Log {
    public $path;
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    public function create(string $description){

    }
    public function get(){
        return file_get_contents($this->path);
    }
}
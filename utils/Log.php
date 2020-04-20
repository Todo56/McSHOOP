<?php
class Log {
    public $path;
    public $enabled;
    public function __construct(string $path, bool $enabled)
    {
        $this->enabled = $enabled;
        $this->path = $path;
    }
    public function create(string $description, int $type){
        $timestamp = date("[d/m/o|H:i:s]");
        switch ($type){
            case 1:
                $type = "[INFO]";
                break;
            case 2:
                $type = "[ERROR]";
                break;
            case 3:
                $type = "[WARNING]";
                break;
        }
        $log =  $timestamp . $type . ": $description";
        file_put_contents($this->path, $this->get() . "\n$log");
        return $log;
    }
    public function get(){
        return file_get_contents($this->path);
    }
}
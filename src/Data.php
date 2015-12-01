<?php

namespace Volter;

class Data
{
    protected $path;
    protected $data = [];
    
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Load data file
     * 
     * @param string $file
     * @return array
     */
    public function load ($file) {
        $path = "{$this->path}/$file.php";
        
        if (!is_file($path)) {
            return [];
        }
        
        return require $path;
    }
    
    /**
     * Get data value by key
     * 
     * @param string $file
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get ($file, $key = '', $default = false) {
        if (!isset($this->data[$file])) {
            $this->data[$file] = $this->load($file);
        }
    
        return $key === ''
            ? $this->data[$file]
            : $this->arrGet($this->data[$file], $key, $default);
    }
    
    /**
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function arrGet ($array, $key, $default = false) {
        if (isset($array[$key])) {
            return $array[$key];
        }
    
        $keys = explode('.', $key);
        $key = array_shift($keys);
    
        while (is_array($array) && isset($array[$key])) {
            $array = $array[$key];
        
            $key = array_shift($keys);
        }
    
        return $key !== null && !isset($array[$key]) ? $default : $array;
    }
}
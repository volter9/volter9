<?php

namespace Volter;

class URL
{
    /**
     * @param string $base
     * @param string $root
     * @return string
     */
    static public function baseUrl($base = '', $root = '')
    {
        $root = $root ?: $_SERVER['DOCUMENT_ROOT'];
        $root = $root ?: $base;
    
        $root = trim($root, '/');
        $base = trim($base, '/');
    
        if ($base === $root) {
            return '';
        }
    
        return substr($base, strlen($root) + 1);
    }
    
    /**
     * @param string $base
     * @param string $root
     * @return string
     */
    static public function url($base = '', $root = '')
    {
        $root = static::baseUrl($base, $root);
        
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        
        if ($root && strpos($url, $root) === 0) {
            $url = substr($url, strlen($root));
            $url = trim($url, '/');
        }

        return $url;
    }
    
    protected $full;
    protected $base;
    
    /**
     * @param string $full
     * @param string $base
     */
    public function __construct($full, $base)
    {
        $this->full = $full;
        $this->base = $base;
    }
    
    /**
     * @param string $url
     * @return string
     */
    public function make($url = '')
    {
        if (strpos($url, 'http') === 0) {
            return $url;
        }
        
        $url = trim("{$this->base}/$url", '/');
    
        if (pathinfo($url, PATHINFO_EXTENSION) === '') {
            $url .= '/';
        }
    
        return preg_replace('/\/+/', '/', "/$url");
    }
    
    /**
     * @param string $url
     * @return string
     */
    public function makeFull($url = '')
    {
        return $this->full . $this->make($url);
    }
    
    /**
     * Is given $url is current $route or in $route
     * 
     * @param string $url
     * @param string $route
     * @return bool
     */
    public function isCurrent($url, $route)
    {
        $url = $url === '' ? 'index' : $url;
        
        return $url === $route 
            || $url !== '' 
            && strpos($route, $url) === 0;
    }
}
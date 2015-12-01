<?php

namespace Volter;

use Bloge\Renderers\IRenderer;
use Jade\Jade;

class JadeRenderer implements IRenderer
{
    protected $jade;
    protected $path;
    
    public function __construct($path, $cache = '')
    {
        $this->path = $path;
        $this->jade = new Jade([
            'prettyprint' => true,
            'cache'       => $cache
        ]);
    }
    
    public function jade()
    {
        return $this->jade;
    }
    
    public function partial($view, array $data = [])
    {
        return $this->jade->render("{$this->path}/$view", $data);
    }
    
    public function render(array $data = [])
    {
        $view = isset($data['view']) ? $data['view'] : '';
        
        return $this->partial($view, $data);
    }
}
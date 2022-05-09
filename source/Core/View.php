<?php

namespace Source\Core;

use League\Plates\Engine;
use CoffeeCode\Router\Router;

/**
 * FSPHP | Class View
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Core
 */
class View {

    /** @var Engine */
    private $engine;

    /** @var Router */
    protected $router;

    /**
     * View constructor.
     * @param string $path
     * @param string $ext
     */
    public function __construct($router,string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT) {
        
        $this->router = $router;
        
        $this->engine = Engine::create($path, $ext);

        $this->engine->addData(["router" => $this->router]);
    }

    /**
     * @param string $name
     * @param string $path
     * @return View
     */
    public function path(string $name, string $path): View {
        $this->engine->addFolder($name, $path);
        return $this;
    }

    /**
     * @param string $templateName
     * @param array $data
     * @return string
     */
    public function render(string $templateName, array $data): string {
        return $this->engine->render($templateName, $data);
    }

    /**
     * @return Engine
     */
    public function engine(): Engine {
        return $this->engine();
    }

}

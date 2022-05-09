<?php

namespace Source\Core;

use Source\Support\Seo;
use Source\Support\Message;
/**
 * Controlador Principal
 *
 * @author Luiz
 */
abstract class Controller {

    /** @var Engine */
    protected $view;
    
    /** @var MESSAGE */
    protected $message;
    
   /** @var SEO */
    protected $seo;
    
    /**
     * 
     * @param string $pathToViews
     */
    public function __construct($router,string $pathToViews = null) {
        $this->view = new View($router,$pathToViews);
        $this->seo = new Seo();
        $this->message = new Message();
    }

    /**
     * 
     * @param string $param
     * @param array $values
     * @return string
     */
    public function ajaxResponse(string $param, array $values): string {
        return json_encode([$param => $values]);
    }

}

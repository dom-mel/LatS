<?php

namespace Dommel\LatsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


class DefaultController extends FOSRestController
{
    /**
     * @Rest\View
     */

    public function indexAction()
    {
        $view = $this->view("Hi here is LatS");
        return $this->handleView($view);
    }
}

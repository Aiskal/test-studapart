<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerGeneral extends AbstractController
{
    public function index(): Response
    {
        return $this->render('/index.html.twig');
    }
}

?>
<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{
    /**
     * @Route("/success", name="app_success")
     */
    public function index(): Response
    {
        return $this->render('success/index.html.twig');
    }
}

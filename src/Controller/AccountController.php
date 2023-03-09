<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }
    
    /**
     * @Route("/compte", name="app_account")
     */
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findOrders($this->getUser());
        return $this->render('account/index.html.twig',[
            'orders' => $orders
        ]);
    }
}

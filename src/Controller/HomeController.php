<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $entityManager;

    /**
     * @param $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }
    
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll(); 
        $categories = $this->entityManager->getRepository(Category::class)->findAll(); 

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="app_product")
     */
    public function indexProduct($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug); 

        if(!$product){
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('home/product.html.twig', [
            'product' => $product,
        ]);
    }
}

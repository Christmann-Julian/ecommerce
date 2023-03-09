<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAdressController extends AbstractController
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
     * @Route("/compte/ajouter-adresse", name="app_account_adress")
     */
    public function index(Cart $cart, Request $request): Response
    {
        // Formulaire pour les adresses
        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $adress->setUser($this->getUser());
            $this->entityManager->persist($adress);
            $this->entityManager->flush();

            if($cart->get()){
                return $this->redirectToRoute('app_order');
            }else{
                return $this->redirectToRoute('app_account');
            }
            
        }
        
        return $this->render('account/adress.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/modifier-adresse/{id}", name="app_account_adress_edit")
     */
    public function edit(Request $request, $id): Response
    {
        // Formulaire pour les adresses
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);
        $form = $this->createForm(AdressType::class, $adress);

        if(!$adress || $adress->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account');
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account');
        }
        
        return $this->render('account/adress.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/compte/supprimer-adresse/{id}", name="app_account_adress_delete")
     */
    public function delete($id): Response
    {
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if($adress && $adress->getUser() == $this->getUser()){
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_account');
    }
}

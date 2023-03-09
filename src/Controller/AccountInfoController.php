<?php

namespace App\Controller;

use App\Form\ChangeInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountInfoController extends AbstractController
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
     * @Route("/compte/modifier-info", name="app_account_info")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {   
        // Formulaire pour les informations de l'utilisateur
        $message = null;
        $message_color = "#f00";
        $user = $this->getUser();
        $form = $this->createForm(ChangeInfoType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();
            
            if($hasher->isPasswordValid($user, $old_password)){
                $firstname = $form->get('firstname')->getData();
                $lastname = $form->get('lastname')->getData();
                $new_password = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_password);
                
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $message = "Votre compte a été mis à jour";
                $message_color = "#58e600";
            }else{
                $message = "Votre mot de passe actuel est incorrect";
            }
        }

        return $this->render('account/info.html.twig', [
            'form'=>$form->createView(),
            'message'=>$message,
            'message_color'=>$message_color
        ]);
    }
}

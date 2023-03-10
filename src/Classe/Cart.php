<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManagerInterface, SessionInterface $sessionInterface)
    {
        $this->session = $sessionInterface;
        $this->entityManager = $entityManagerInterface;
    }

    public function get(){
        return $this->session->get('cart');
    }

    public function getFull(){
        $cartComplete = [];

        if($this->get()){
            foreach($this->get() as $id => $quantity) {
                $product_obj = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if(!$product_obj){
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_obj,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }

    public function add($id){
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function decrease($id){
        $cart = $this->session->get('cart', []);

        if($cart[$id] > 1){
            $cart[$id]--;
        }else{
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function remove(){
        return $this->session->remove('cart');
    }

    public function delete($id){
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }
}
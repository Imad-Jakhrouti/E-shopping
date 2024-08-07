<?php

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    public function __construct(private requestStack $requestStack)
    {

    }

    public  function getCart(){
        return $this->requestStack->getSession()->get('cart');
    }

    public function addToCart($product){

        $cart = $this->requestStack->getSession()->get('cart', []);

        if(isset($cart[$product->getId()])){
            $cart[$product->getId()]['quantity']++;
        }
        else{
            $cart[$product->getId()]=[
                'product' => $product,
                'quantity' => 1,
            ];
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }
    public  function decrease($id){
        $cart = $this->requestStack->getSession()->get('cart', []);
        if(isset($cart[$id])){
            if($cart[$id]['quantity']>1){
                $cart[$id]['quantity'] =  $cart[$id]['quantity'] - 1;
            }else{
                unset($cart[$id]);
            }
        }
        $this->requestStack->getSession()->set('cart', $cart);

    }

    public function removeFromCart($id){
        $cart = $this->requestStack->getSession()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }
    public function removeAllFromCart(){
        return $this->requestStack->getSession()->remove('cart');
    }

    public function getTotalPriceWt(){
        $cart = $this->requestStack->getSession()->get('cart', []);
        $price = 0;
        if(!isset($cart)){
            return $price;
        }

        foreach($cart as $myCart){
            $price += $myCart['product']->getPriceWt() * $myCart['quantity'];
        }
        return $price;
    }
    public function fullQuantity(){
        $cart = $this->requestStack->getSession()->get('cart', []);
        $quantity = 0;

        if(!isset($cart)){
            return $quantity;
        }
        foreach($cart as $product){
            $quantity += $product['quantity'];
        }
        return $quantity;
    }
}
<?php

namespace App\Class;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    public function removeAllFromCart(){
        return $this->requestStack->getSession()->remove('cart');
    }

    public function removeFromCart($id){
        $cart = $this->requestStack->getSession()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
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


}
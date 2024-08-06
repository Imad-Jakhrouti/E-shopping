<?php

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{

    public function __construct(private requestStack $requestStack)
    {

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

}
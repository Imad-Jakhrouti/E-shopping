<?php

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;

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

    #[Route('/cart/increase/{id}', name: 'app_cart_increase')]
    public function increase($id, ProductRepository $productRepository , Cart $cart,Request $request): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);
        $cart->addToCart($product);
        $this->addFlash(
            'success',
            'Votre produit a ete bien augmenter !'
        );


        return $this->redirect($request->headers->get('referer'));
    }


}
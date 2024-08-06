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

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id, Cart $cart,Request $request): Response
    {
        $cart->decrease($id);
        $this->addFlash(
            'success',
            'Votre produit a ete bien deminiue de votre panier !'
        );


        return $this->redirectToRoute('app_cart');
    }


}
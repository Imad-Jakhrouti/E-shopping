<?php

namespace App\Controller;

use App\Class\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {

        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getCart(),
            'totalPriceWt' => $cart->getTotalPriceWt(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, ProductRepository $productRepository , Cart $cart,Request $request): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);
        $cart->addToCart($product);
        $this->addFlash(
            'success',
            'Votre produit a ete bien ajouter au votre panier !'
        );


        return $this->redirect($request->headers->get('referer'));
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

    #[Route('/cart/removeAll', name: 'app_cart_removeAll')]
    public function removeAll(Cart $cart): Response
    {

        $cart->removeAllFromCart();
        return $this->redirectToRoute('app_home');
    }
    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove($id, Cart $cart): Response
    {

        $cart->removeFromCart($id);
        return $this->redirectToRoute('app_cart');
    }


}

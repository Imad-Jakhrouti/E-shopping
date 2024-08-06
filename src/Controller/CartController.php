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
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, ProductRepository $productRepository , Cart $cart,Request $request): Response
    {
        $product = $productRepository->findOneBy(['id' => $id]);
        $cart->addToCart($product);
        return $this->redirect($request->headers->get('referer'));
    }
}

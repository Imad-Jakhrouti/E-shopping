<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use App\Repository\AddressRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{

    /*
     * 1ere etape du tunnel d'achat:
     *      Choix de l'adresse de livraison et de transporteur
     *
     * */
    #[Route('/commande/livraison', name: 'app_order')]
    public function index(): Response
    {
        $addresses = $this->getUser()->getAddresses();
        if (count($addresses) == 0) {
            return $this->redirectToRoute('app_account_address_form', ['action' => 'ajouter', 'redirectToOrder' => true]);
        }
        // c'est un objet de type FormInterface
        $form = $this->createForm(OrderType::class, null ,[
            'addresses' => $addresses,
            'action' => $this->generateUrl('app_order_summary')
        ]);
        return $this->render('order/index.html.twig', [
            'deliveryForm' => $form->createView(),// c'est un objet de type ViewInterface
        ]);
    }

    /*
    * 2eme etape du tunnel d'achat:
    *      recap de la commande d'utilisateur
    *      insertion au base de donnee
    *      prepation de paiement vers stripe
    * */
    #[Route('/commande/recapitulatif', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {

        if($request->getMethod()!= 'POST'){
            return $this->redirectToRoute('app_order');
        }
        $form = $this->createForm(OrderType::class, null ,[
            'addresses' => $this->getUser()->getAddresses(),
        ]);
        $form->handleRequest($request);
        $myCart = $cart->getCart();

        if($form->isSubmitted() && $form->isValid()){
          //
        }

        return $this->render('order/summary.html.twig', [
            'choices' => $form->getData(),
            'cart' => $myCart,
            'totalPriceWt' => $cart->getTotalPriceWt(),
        ]);
    }
}

<?php

namespace App\Controller\Account;

use App\Entity\Address;
use App\Form\AddressUserType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddressController extends AbstractController
{
    public function __construct( private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/compte/adresses', name: 'app_account_addresses')]
    public function index(): Response
    {
        return $this->render('account/address/index.html.twig');
    }

    #[Route('/compte/adresse/delete/{id}', name: 'app_account_address_delete')]
    public function delete($id, AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findOneBy(['id' => $id]);
        if(!$address OR $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account_addresses');
        }
        $this->entityManager->remove($address);
        $this->entityManager->flush();
        $this->addFlash(
            'success',
            'Votre adresse est correctement supprimer!'
        );
        return $this->redirectToRoute('app_account_addresses');
    }

    #[Route('/compte/adresse/{action}/{id}', name: 'app_account_address_form',requirements: ['action' => 'ajouter|modifier'],defaults: [ 'id' => null])]
    public function form($id, $action,Request $request ,AddressRepository $addressRepository): Response
    {
        if($id and $action == 'modifier'){
            $address = $addressRepository->findOneBy(['id'=>$id]);
            if(!$address OR $address->getUser() != $this->getUser()){
                return $this->redirectToRoute('app_account_addresses');
            }
        }else{
            $address = new Address();
            $address->setUser($this->getUser());
        }
        $form = $this->createForm(AddressUserType::class,$address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'Votre adresse est correctement sauvgarder!'
            );
            return $this->redirectToRoute('app_account_addresses');
        }
        return $this->render('account/address/form.html.twig',[
            'addressForm' => $form->createView(),
        ]);
    }

}

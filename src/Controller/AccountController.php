<?php

namespace App\Controller;

use App\Form\ModifyPasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
    #[Route('/compte/modifier_mot_de_passe', name: 'app_account_modify_password')]
    public function modifyPassword(Request $request , UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifyPasswordUserType::class , $user , [
            'hasher' => $hasher,
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre message est bien ete modifier!'
            );
        }
        return $this->render('account/modifyPassword.html.twig',[
            'modifyPasswordForm' => $form->createView(),
        ]);
    }

    #[Route('/compte/adresses', name: 'app_account_addresses')]
    public function address(): Response
    {
        return $this->render('account/address.html.twig');
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

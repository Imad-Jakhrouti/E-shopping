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


}

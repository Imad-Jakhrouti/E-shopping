<?php

namespace App\Controller\Account;

use App\Form\ModifyPasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class PasswordController extends AbstractController
{
    public function __construct( private EntityManagerInterface $entityManager)
    {
    }


    #[Route('/compte/modifier_mot_de_passe', name: 'app_account_modify_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifyPasswordUserType::class , $user , [
            'hasher' => $hasher,
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'Votre message est bien ete modifier!'
            );
        }
        return $this->render('account/password/index.html.twig',[
            'modifyPasswordForm' => $form->createView(),
        ]);
    }



}

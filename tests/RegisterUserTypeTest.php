<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTypeTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1. Cree un faux client (navigateur) de pointer vers une URL(jouer une URL)
        // 2. Remplire les champs de mon formulaire d'inscription
        // 3. Est-ce-que tu peut regarder si dans mon page j'ai le message d'alert suivant: "Inscription reussite veuillez vous connecter!"


        // Cree un faux client (navigateur)
        $client = static::createClient();
        // Pointer vers une URL(jouer une URL)
        $client->request('GET' ,'/inscription');
        // 2. Remplire les champs de mon formulaire d'inscription
        $client->submitForm('Valider votre formulaire',[
            'register_user[email]' => 'test@test.com',
            'register_user[plainPassword][first]' => 'password',
            'register_user[plainPassword][second]' => 'password',
            'register_user[firstname]' => 'Imad',
            'register_user[lastname]' => 'Test',
        ]);

        // assurer la redirection
        $this->assertResponseRedirects('/connexion');
        // make the client follow the redirection
        $client->followRedirect();

        // 3. Est-ce-que tu peut regarder si dans mon page j'ai le message d'alert suivant: "Inscription reussite veuillez vous connecter!"
        $this->assertSelectorExists('div:contains("Inscription reussite veuillez vous connecter!")');
    }
}

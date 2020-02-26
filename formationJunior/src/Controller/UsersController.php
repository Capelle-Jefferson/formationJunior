<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\NewUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/inscription", name="security_registration")
     */
    public function registration(Request $request)
    {
        $user = new Users;
        $form = $this->createForm(NewUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('users/registration.html.twig', [
            'formRegistration' => $form->createView(),
        ]);
    }
}

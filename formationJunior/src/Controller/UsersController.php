<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\NewUserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/inscription", name="users_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users;
        $form = $this->createForm(NewUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("users_login");
        }

        return $this->render('users/registration.html.twig', [
            'formRegistration' => $form->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="users_login")
     */
    public function login(){
        return $this->render("users/login.html.twig");
    }

    /**
     * @Route("/deconnexion", name="users_logout")
     */
    public function logout(){}
}

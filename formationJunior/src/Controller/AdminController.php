<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function usersAdministration()
    {

        $users = $this->getDoctrine()
                      ->getRepository(Users::class)
                      ->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}

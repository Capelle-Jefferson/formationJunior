<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Repository\UsersRepository;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function usersAdministration(UsersRepository $users)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/role_update/{id}", name="roleUpdate")
     */
    public function roleUpdate($id){
        $user = $this->getDoctrine()
                      ->getRepository(Users::class)
                      ->find($id);

        $user->setRoles([$_POST["role"]]);
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->flush();
        return $this->redirect("/admin");
    }
}

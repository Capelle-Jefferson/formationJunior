<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Articles;
use App\Entity\Users;
use App\Entity\Commentaires;
use App\Entity\CategorieArticle;
use App\Form\ArticleFormType;
use App\Form\ArticlesByCategorieType;
use App\Form\CommentaireFormType;
use Doctrine\Common\Persistence\ObjectManager;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request)
    {
        $cat = new CategorieArticle();
        $form = $this->createForm(ArticlesByCategorieType::class, $cat);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $cat = $this->getDoctrine()
                        ->getRepository(CategorieArticle::class)
                        ->findOneBy(['name' => $cat->getName()]);

            $articles = $this->getDoctrine()
                             ->getRepository(Articles::class)
                             ->findBy(['categorie' => $cat->getId()]);
        }else{
            
            $articles = $this->getDoctrine()
                             ->getRepository(Articles::class)
                             ->findAll();
		}

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'articlesByCategorieType' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/nouveau", name="nouveau_article")
     */
    public function newArticle(Request $request){
        $article = new Articles();
        $isForm = false;
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){ 
            $article->setAuteur($this->getDoctrine()
                                ->getRepository(Users::class)
                                ->find(1));
            $article->setDate(new \DateTime("now"));
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($article);
            $doctrine->flush();
            $isForm = true;
        }
        return $this->render('articles/newArticle.html.twig', [
            'articleForm' => $form->createView(),
            'isForm' => $isForm,
        ]);
     }

    /**
     * @Route("/article/{id}", name="article")
     */
     public function article($id, Request $request)
     {
            $article = $this->getDoctrine()
                    ->getRepository(Articles::class)
                    ->find($id);
            if(!$article){
                throw $this->createNotFoundException("L'article recherch� n'existe pas");
			}

            $commentaire = new Commentaires;
            $form = $this->createForm(CommentaireFormType::class, $commentaire);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $commentaire->setArticle($article);
                $commentaire->setDate(new \DateTime("now"));
                $commentaire->setAuteur($this->getUser());
                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->persist($commentaire);
                $doctrine->flush();
            }

            $commentaires = $this->getDoctrine()
                      ->getRepository(Commentaires::class)
                      ->findBy([
                        'article' => $id,
                      ]); 
            return $this->render('articles/article.html.twig', [
                          'article' => $article,
                          'commentaires' => $commentaires,
                          'formCommentaire' => $form->createView(),
            ]);
     }
     

}
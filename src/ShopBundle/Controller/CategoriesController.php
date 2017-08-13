<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        #$categoriesRep = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $em->getRepository('ShopBundle:Categories')->findAll();

        return $this->render('ShopBundle:categories:index.html.twig', array(
             'categories' => $categories,
        ));
    }

}

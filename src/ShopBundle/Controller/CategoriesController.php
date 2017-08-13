<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ShopBundle:Categories')->findAll();

        return $this->render('ShopBundle:categories:index.html.twig', array(
             'categories' => $categories,
        ));
    }

}

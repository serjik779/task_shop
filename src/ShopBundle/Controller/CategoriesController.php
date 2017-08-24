<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ShopBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoriesController extends Controller
{
//    public function indexAction() {
//        $em = $this->getDoctrine()->getManager();
//
//        #$categoriesRep = $this->getDoctrine()->getRepository(Categories::class);
//        $categories = $em->getRepository(Categories::class)->findAll();
//
//        return $this->render('ShopBundle:categories:index.html.twig', array(
//             'categories' => $categories,
//        ));
//    }

    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $model = $this->get('doctrine')->getManager()->getRepository(Categories::class)->findAll();
        $vm = $this->get('allcategories.view_model_assembler')->generateViewModel($model);
        return array(
            'vm' => $vm,
        );
    }
}

<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Brands;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Feedback;
use ShopBundle\Entity\Images;
use ShopBundle\Entity\Pages;
use ShopBundle\Entity\Slider;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Test\Fixture\Document\Image;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $model1 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('onMain' => 1, 'isVisible' => 1));
        $model2 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy([], ['created' => 'DESC'], 10);
        $model3 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('top' => 1), [], 4);
        $model4 = $this->get('doctrine')->getManager()->
        getRepository(Products::class)->findBy(array('top' => 1), ['created' => 'DESC'], 4);
        $model5 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Brands::class)
            ->findAll();
        $model6 = $this->get('doctrine')
            ->getManager()
            ->getRepository(Slider::class)
            ->findAll();

        $vm = $this->get('shop.index_view_model_assembler')->generateViewModel($model1, $model2, $model3, $model4, $model5 , $model6);

        return $this->render('ShopBundle:home:index.html.twig', array
        (
            'vm' => $vm,
        ));
    }
}



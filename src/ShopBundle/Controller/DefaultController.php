<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
         return $this->render('ShopBundle:home:index.html.twig');
    }

    public function contactVendorAction(Request $request)
    {
        $form = $this->createFormBuilder(new Feedback())
            ->add('name', TextType::class, array(
                'label' => 'Name'))
            ->add('email', EmailType::class, array(
                'label' => 'Email'))
            ->add('text', TextareaType::class, array(
                'label' => 'Message'))
            ->add('save', SubmitType::class, array(
                'label' => 'Send'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();

            return $this->redirectToRoute('shop_contact');
        }

        return $this->render('ShopBundle:Static:contactVendor.html.twig', array(
            'navigation_active' => 'others',
            'form' => $form->createView(),
        ));
    }

    public function aboutAction()
    {

        return $this->render('ShopBundle:Static:about.html.twig', array(
            'navigator_active' => 'others',
        ));
    }

}

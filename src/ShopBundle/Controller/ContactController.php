<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Feedback;
use ShopBundle\Entity\Pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function contactVendorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

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
            /* @var $feedback Feedback */
            $feedback = $form->getData();

            $em->persist($feedback);
            $em->flush();


            $message = (new \Swift_Message('Feedback message.'))
                ->setFrom('alona.ant@bk.ru')
                ->setTo('alona.ant@bk.ru')
                ->setBody("User: " . $feedback->getName() . ". " . " User Email: " . $feedback->getEmail() . ". " . " Message: " . $feedback->getText(), 'text/plain');

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('shop_contact');
        }

        $page = $em->getRepository(Pages::class)->findOneBy(['title' => 'contact']);

        return $this->render('ShopBundle:Static:contactVendor.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
            'page' => $page
        ));
    }
}
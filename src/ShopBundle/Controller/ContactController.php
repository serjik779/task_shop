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
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class ContactController extends Controller
{
    public function contactVendorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $form = $this->createFormBuilder(new Feedback())
            ->add('name', TextType::class, array(
                'constraints' => array(new Length(array('min' => 3))),
                'label' => 'Name'))
            ->add('email', EmailType::class, array(
                'constraints' => array(new Email(array('message'=>'This is not the correct email format'))),
                'label' => 'Email'))
            ->add('text', TextareaType::class, array(
                'constraints' => array(new Length(array('min' => 5))),
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
                ->setTo($this->getParameter('mailer_user'))
                ->setBody("User: " . $feedback->getName() . ". " . " User Email: " . $feedback->getEmail() . ". " . " Message: " . $feedback->getText(), 'text/plain');

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('shop_contact');
        }

        $page = $em->getRepository(Pages::class)->findOneBy(['title' => 'contact']);

        return $this->render('ShopBundle:Static:contactVendor.html.twig', array(
            'page' => $page,
            'form' => $form->createView()
        ));
    }
}
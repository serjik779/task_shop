<?php


namespace ShopBundle\Controller;

use ShopBundle\Entity\Pages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    public function aboutAction()
    {
        $logger = $this->container->get('logger');
        $logger->info('I just got the logger');
        $logger->error('An error occurred');

        $logger->critical('I left the oven on!', array(
            // include extra "context" info in your logs
            'cause' => 'in_hurry',
        ));
         $em = $this->getDoctrine()->getManager();
         $page = $em->getRepository(Pages::class)->findOneBy(['title' => 'about']);
         return $this->render('ShopBundle:Static:about.html.twig', array(
             'navigator_active' => 'others',
             'page' => $page
         ));
    }
}
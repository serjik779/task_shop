<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class WishlistController extends Controller{

    public function wishlistAction()
    {

        return $this->render('ShopBundle:my-wishlist:wishlist.html.twig', array(
            'navigator_active' => 'others',

        ));
    }
}
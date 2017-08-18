<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Feedback;
use ShopBundle\Entity\Products;
use ShopBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class WishlistController extends Controller{

    public function wishlistAction()
    {


        $em = $this->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository(Users::class)->findById(2);
        return $this->render('ShopBundle:my-wishlist:wishlist.html.twig', array(
            'users' => $user
        ));

    }
}
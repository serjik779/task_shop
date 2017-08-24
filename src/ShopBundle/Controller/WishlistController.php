<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use ShopBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WishlistController extends Controller
{
    public function wishlistAction()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository(Users::class)->findById(2);

        return $this->render('ShopBundle:my-wishlist:wishlist.html.twig', array(
            'user' => reset($user)
        ));
    }

    /* @var $user Users
     *  @var $product Products */
    public function addWishlistProductAction($user,$product){
        $em = $this->get('doctrine.orm.default_entity_manager');
        $user->addProducts($product);
        $em->persist($product);
        $em->persist($user);
        $em->flush();
    }
}


<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Application\Sonata\UserBundle\Entity\User;
use ShopBundle\Entity\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WishlistController extends Controller
{
    public function wishlistAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $wishlist = $em->getRepository(Wishlist::class)->findBy(array('user' => $user));

        return $this->render('ShopBundle:my-wishlist:wishlist.html.twig', array(
            'wishlist' => $wishlist
        ));
    }

    /* @var $request Request
     */
    public function addWishlistProductAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            $response = array('status' => 'error', 'data' => array('message' => 'Invalid user'));
            return $this->render('ShopBundle::output.json.twig', array('data' => json_encode($response)));
        }
        $em = $this->get('doctrine.orm.default_entity_manager');
        $productId = $request->get('product', null);
        $product = $em->getRepository(Products::class)->find($productId);
        $wishlist = $em->getRepository(Wishlist::class)->findOneBy(array(
            'user' => $user,
            'product' => $product
        ));
        if (!$wishlist) {
            $wishlist = new Wishlist();
            $wishlist->setProduct($product)->setUser($this->getUser());

            $em->persist($wishlist);
            $em->flush();
        }
        return $this->render('ShopBundle::output.json.twig', array('data' => 1));
    }
}


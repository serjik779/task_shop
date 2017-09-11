<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Application\Sonata\UserBundle\Entity\User;
use ShopBundle\Entity\Wishlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function addWishlistProductAction(Request $request)
    {
        $response = [
            'status' => 'ok',
            'data' => [],
        ];

        $user = $this->getUser();

        if (!$user) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid user.';

            return new Response(json_encode($response));
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

        return new Response(json_encode($response));
    }

    public function deleteFromWishlistAction(Request $request)
    {
        $jsonResponse = [
            'status' => 'ok',
            'message' => '',
        ];

        $em = $this->get('doctrine.orm.default_entity_manager');
        $user = $this->getUser();

        $productId = $request->get('product', null);
        $product = $em->getRepository(Products::class)->find($productId);
        $productForRemoval = $em->getRepository(Wishlist::class)->findOneBy(array(
            'user' => $user,
            'product' => $product,
        ));

        if (!empty($productForRemoval)) {
            $em->remove($productForRemoval);
            $em->flush();
        }

        if ($request->isMethod('post')) {
            return new JsonResponse($jsonResponse);
        }

        return $this->redirectToRoute('shop_wishlist');
    }
}

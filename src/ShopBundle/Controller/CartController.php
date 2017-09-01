<?php

namespace ShopBundle\Controller;


use ShopBundle\Entity\Cart;
use ShopBundle\Entity\CartItems;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function indexAction() {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirect($this->generateUrl('auth_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository(Cart::class)->findOneBy(array('user' => $this->getUser()));
        $cartItems = $em->getRepository(CartItems::class)->findBy(array('cart' => $cart));
        return $this->render('ShopBundle:cart:index.html.twig', array(
            'cartItems' => $cartItems
        ));
    }

    public function addAction(Request $request) {
        $user = $this->getUser();
        if (!$user) {
            $response = array('status' => 'error', 'data' => array('message' => 'Invalid user'));
            return $this->render('ShopBundle::output.json.twig', array('data' => json_encode($response)));
        }

        $serializer = $this->get('jms_serializer');
        $productId = $request->get('product');
        $amount = $request->get('amount', 1);

        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository(Products::class)->find($productId);

        $cart = $em->getRepository(Cart::class)->findOneBy(array('user' => $user));

        if (!$cart) {
            $cart = new Cart();
            $cart->setCreated(new \DateTime())
                ->setUser($user);
        }
        $em->persist($cart);

        $cartItem = $em->getRepository(CartItems::class)->findOneBy(array('cart' => $cart, 'product' => $product));

        if (!$cartItem) {
            $cartItem = new CartItems();
            $cartItem->setAmount($amount)
                ->setCart($cart)
                ->setProduct($product)
                ->setDiscount(0);
        } else {
            $cartAmount = $cartItem->getAmount();
            $cartItem->setAmount($amount + $cartAmount);
        }
        $em->persist($cartItem);
        $em->flush();

        $response = array('status' => 'success', 'data' => array('product' => $product, 'amount' => $amount));
        $response = $serializer->serialize($response, 'json');
        return $this->render('ShopBundle::output.json.twig', array('data' => $response));
    }
}

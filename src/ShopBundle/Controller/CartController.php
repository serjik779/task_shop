<?php

namespace ShopBundle\Controller;



use JMS\Serializer\Tests\Fixtures\Order;
use PHPUnit\Runner\Exception;
use ShopBundle\Entity\Cart;
use ShopBundle\Entity\CartItems;
use ShopBundle\Entity\DeliveryType;
use ShopBundle\Entity\OrderItems;
use ShopBundle\Entity\OrdersInfo;
use ShopBundle\Entity\Products;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function indexAction(Request $request) {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirect($this->generateUrl('shop_login'));
        }
        $em = $this->getDoctrine()->getManager();
        $cart = $em->getRepository(Cart::class)->findOneBy(array('user' => $this->getUser()));
        $cartItems = $em->getRepository(CartItems::class)->findBy(array('cart' => $cart));
        $form = $this->createFormBuilder(new OrdersInfo())
            ->add('date', DateTimeType::class, array(
                'label' => 'date'))
            ->add('name', TextType::class, array(
                'label' => 'Name'))
            ->add('address', TextType::class, array(
                'label' => 'Address'))
            ->add('phone', TextType::class, array(
                'label' => 'Phone'))
            ->add('deliveryType', EntityType::class, array(
                'label' => 'Delivery', 'class' => DeliveryType::class))
            ->add('Checkout', SubmitType::class, array(
                'label' => 'Send'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && !empty($cartItems)) {
            /* @var $feedback OrdersInfo */
            $ordersInfo = $form->getData();
            $em->persist($ordersInfo);

            foreach ($cartItems as $cartItem) {
                $orderItems = new OrderItems();
                $orderItems->setAmount($request->get('amount'.$cartItem->getProduct()->getId()))
                    ->setDiscount(0)
                    ->setProducts($cartItem->getProduct())
                    ->setOrdersInfo($ordersInfo);
                $em->persist($orderItems);
                $em->remove($cartItem);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('shop_homepage'));
        }

        return $this->render('ShopBundle:cart:index.html.twig', array(
            'cartItems' => $cartItems,
            'form' => $form->createView()
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
        $em->getConnection()->beginTransaction();
        try {
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
                $amount = 0;
            }
            $em->persist($cartItem);
            $em->flush();
            $em->getConnection()->commit();

            $response = array('status' => 'success', 'data' => array('product' => $product, 'amount' => $amount, 'cost' => $product->getCost()));
            $response = $serializer->serialize($response, 'json');

            return $this->render('ShopBundle::output.json.twig', array('data' => $response));
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }
    }

    public function deleteAction(Request $request) {
        $cartItemId = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $cartItem = $em->getRepository(CartItems::class)->find($cartItemId);

        $em->remove($cartItem);
        $em->flush();

        return $this->redirect($this->generateUrl('cart_index'));
    }

    public function checkoutAction(Request $request) {

        return $this->render('ShopBundle:cart:index.html.twig', array(

        ));
    }
}

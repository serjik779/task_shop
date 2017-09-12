<?php
namespace ShopBundle\Controller;

use ShopBundle\Entity\Products;
use Application\Sonata\UserBundle\Entity\User;
use ShopBundle\Entity\OrdersInfo;
use ShopBundle\Entity\OrderItems;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyOrdersController extends Controller
{
    public function myordersAction()
    {


        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(OrdersInfo::class)->findBy(array ('user'=>$this->getUser()));
        $orderItems = $em->getRepository(OrderItems::class)->findBy(array ('ordersInfo'=>$orders));




        return $this->render('ShopBundle:MyOrders:myorders.html.twig', array(
            'orders'=> $orders,
            'orderItems'=> $orderItems,


        ));
    }
}
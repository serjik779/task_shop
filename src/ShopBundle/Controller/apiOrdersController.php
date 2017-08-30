<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\OrdersInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use ShopBundle\Entity\OrderItems;



class apiOrdersController extends FOSRestController{
    /**
     * @Rest\Get ("/api/orders")
     */
    public function getAction()
    {

//        $request = $this->getRequest();
//        $token = $request->get('token');

        $restresult = $this->getDoctrine()->getRepository(OrdersInfo::class)->findAll();
        if ($restresult === null) {
            return new View("there are no orders exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}
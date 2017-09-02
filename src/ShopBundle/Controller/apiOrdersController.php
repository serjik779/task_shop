<?php

namespace ShopBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use ShopBundle\Entity\OrdersInfo;
use Symfony\Component\HttpFoundation\Response;


class apiOrdersController extends FOSRestController
{
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
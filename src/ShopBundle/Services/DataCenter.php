<?php

namespace ShopBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class DataCenter
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getData(Request $request) {
        $data = 'nothing';
        if ($request->getMethod() == 'POST') {
            $data = $request->get('getCategories', null);
            $data = $data == 1 ? 'categories' : 'products';
        }
        return $data;
    }

}
<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class ServiceLinkController extends Controller
{
    public function listAction(Request $request)
    {
        $data = 'nothing';
        if ($request->getMethod() == 'POST') {
            $data = $request->get('getCategories', null);
            $data = $data == 1 ? 'categories' : 'products';
        }

        return $this->render('ShopBundle:service:index.html.twig', array(
            'data'  => $data,
        ));
    }
}

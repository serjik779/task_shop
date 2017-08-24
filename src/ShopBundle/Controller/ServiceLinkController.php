<?php

namespace ShopBundle\Controller;

use ShopBundle\Admin\ServiceLinkAdmin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class ServiceLinkController extends Controller
{
    public function listAction(Request $request)
    {
        $data = $this->get('data_center')->getData($request);

        return $this->render('ShopBundle:service:index.html.twig', array(
            'data'  => $data,
        ));
    }
}

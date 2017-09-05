<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\OrdersInfo;
use ShopBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use ShopBundle\Entity\OrderItems;
use Application\Sonata\UserBundle\Entity\User;

class apiOrdersController extends FOSRestController
{

    /**
     * @Rest\Get("/api/orders")
     * @param Request $request
     * @return array|View
     */
    public function getOrdersAction(Request $request)
    {
        $token = $request->get('token');
        $password = $request->get('password');
        $username = $request->get('username');
        if ($token) {
            $res = $this->tokenAuth($token, 'order');
            return new View($res, Response::HTTP_NOT_FOUND);
        } elseif ($password && $username) {
            $res = $this->passwordAuth($username, $password);
            return new View($res, Response::HTTP_NOT_FOUND);
        } else {
            $data['error'] = "Access denied! You dont have username or password!";
            return new View($data, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param $username
     * @param $password
     * @return string
     */
    public function getMyToken($username, $password)
    {
        $users = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $users->getRepository(User::class)->findByUsername($username);
        if (!empty($user)){
            $salt = $user[0]->getSalt();
            $salted = $password.'{'.$salt.'}';
            $digest = hash('sha512', $salted, true);
            for ($i=1; $i<5000; $i++) {
                $digest = hash('sha512', $digest.$salted, true);
            }
            $encodedPassword = base64_encode($digest);
            if ($user[0]->getPassword() == $encodedPassword){
                $role = $user[0]->getGroupNames();
                if (empty($role)){
                    return 'Error';
                }else{
                    if (($role[0] == 'ROLE_STAFF')||($role[0] == 'ROLE_ADMIN')||($role[0] == 'ROLE_SUPER_ADMIN')||($role[0] == 'Service')){
                        $update = strtotime($user[0]->getUpdatedToken()->format('Y-m-d H:i:s'));
                        if ((time()-$update)>3600) {
                            $token = $this->generationToken();
                            $user[0]->setToken($token);
                            $time = new \DateTime();
                            $user[0]->setUpdatedToken($time);
                            $users->persist($user[0]);
                            $users->flush();
                            return $user[0]->getToken();
                        }else{
                            if (is_null($user[0]->getToken())){
                                $token = $this->generationToken();
                                $user[0]->setToken($token);
                                $time = new \DateTime();
                                $user[0]->setUpdatedToken($time);
                                $users->persist($user[0]);
                                $users->flush();
                            }
                            return $user[0]->getToken();
                        }
                    }else return 'Error';
                }
            }else return 'Error';
        }else{
            return 'Error';
        }
    }
    /**
     * @param $token
     * @param $name
     * @param null $date
     * @return mixed
     */

    public function tokenAuth($token, $name, $date = null)
    {
        $users = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $users->getRepository(User::class)->findByToken($token);
        if (!empty($user)) {
            $update = strtotime($user[0]->getUpdatedToken()->format('Y-m-d H:i:s'));
            if ((time() - $update) > 3600) {
                $data['error'] = "The access time for this token has expired, request a new token!";
                return $data;
            } else {
                switch ($name) {

                    case 'order':
                        return $this->order();
                }
            }
        } else {
            $data['error'] = "Access denied!";
            return $data;
        }
    }
    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    private function passwordAuth($username, $password)
    {
        $myToken = $this->getMyToken($username, $password);
        if ($myToken === 'Error'){
            $data['error'] = "Access denied!";
            return $data;
        }else {
            $token['token'] = $myToken;
            return $token;
        }
    }

    /**
     * @return mixed
     */
    private function order()
    {

        $restresult = $this->getDoctrine()->getRepository(OrdersInfo::class)->findAll();
        if ($restresult === null) {
            return new View("there are no orders exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/api/setCount")
     * @param Request $request
     * @return array|View
     */
    public function setCountAction(Request $request) {
        $amounts = json_decode(file_get_contents("php://input"), true);
        $amounts = json_decode('[{"id":1,"amount":32},{"id":4,"amount":32},{"id":5,"amount":20},{"id":2,"amount":23},{"id":6,"amount":23},{"id":12,"amount":13},{"id":11,"amount":25},{"id":10,"amount":23},{"id":9,"amount":15},{"id":8,"amount":14},{"id":3,"amount":23},{"id":7,"amount":23},{"id":13,"amount":13},{"id":20,"amount":12},{"id":22,"amount":23},{"id":21,"amount":15},{"id":23,"amount":25},{"id":19,"amount":17},{"id":18,"amount":19},{"id":17,"amount":18},{"id":16,"amount":16},{"id":15,"amount":26},{"id":14,"amount":24},{"id":33,"amount":15},{"id":32,"amount":23},{"id":31,"amount":23},{"id":30,"amount":21},{"id":29,"amount":18},{"id":28,"amount":15},{"id":27,"amount":14},{"id":26,"amount":26},{"id":25,"amount":13},{"id":24,"amount":17}]');
        $em = $this->getDoctrine()->getManager();

        $token = $request->get('token');
        $password = $request->get('password');
        $username = $request->get('username');
        if ($token) {
            $res['success'] = 1;

            foreach ($amounts as $amount) {
                $product = $em->getRepository(Products::class)->findOneBy(array('serviceId' => $amount->id));
                if (!empty($product)) {
                    $product->setAmount($amount->amount);
                    $em->persist($product);
                    $em->flush();
                }
            }

            return new View($res, Response::HTTP_NOT_FOUND);
        } elseif ($password && $username) {
            $res = $this->passwordAuth($username, $password);
            return new View($res, Response::HTTP_NOT_FOUND);
        } else {
            $data['error'] = "Access denied! You dont have username or password!";
            return new View($data, Response::HTTP_NOT_FOUND);
        }
    }
}



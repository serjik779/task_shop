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
            return new View($res, Response::HTTP_CREATED);
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
     * @Rest\Get("/api/set-count")
     * @param Request $request
     * @return array|View
     */
    public function setCountAction(Request $request, $json = array()) {
        $amounts = empty($json) ? json_decode(file_get_contents("php://input"), true) : $json;
        $em = $this->getDoctrine()->getManager();

        $token = $request->get('token');
        $password = $request->get('password');
        $username = $request->get('username');
        if ($token) {
            $this->get('adding.product')->setCount($request);
            return new View($res, Response::HTTP_ACCEPTED);
        } elseif ($password && $username) {
            $res = $this->passwordAuth($username, $password);
            return new View($res, Response::HTTP_NOT_FOUND);
        } else {
            $data['error'] = "Access denied! You dont have username or password!";
            return new View($data, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Rest\Get("/api/set-order-status")
     * @param Request $request
     * @return array|View
     */
    public function setOrderStatusAction(Request $request) {
        $status = json_decode(file_get_contents("php://input"), true);
        $em = $this->getDoctrine()->getManager();

        $token = $request->get('token');
        $password = $request->get('password');
        $username = $request->get('username');
        if ($token) {
            $res['success'] = 1;
            foreach ($status as $st) {
                $orderInfo = $em->getRepository(OrdersInfo::class)->find($st['id']);
                if (!empty($product)) {
                    $orderInfo->setStatus($st['status']);
                    $em->persist($orderInfo);
                    $em->flush();
                }
            }
            return new View($res, Response::HTTP_ACCEPTED);
        } elseif ($password && $username) {
            $res = $this->passwordAuth($username, $password);
            return new View($res, Response::HTTP_NOT_FOUND);
        } else {
            $data['error'] = "Access denied! You dont have username or password!";
            return new View($data, Response::HTTP_NOT_FOUND);
        }
    }
}



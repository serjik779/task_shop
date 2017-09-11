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
use Application\Sonata\UserBundle\Entity\User;

class apiOrdersController extends FOSRestController
{

    /**
     * @Rest\Get("/api/auth")
     * @param Request $request
     * @return array|View
     */
    public function getTokenAction(Request $request)
    {
//        $token = $request->get('token');
        $password = $request->get('password');
        $username = $request->get('username');
//        $date = $request->get('date');

            if ($password && $username) {
            $res = $this->passwordAuth($username, $password);
            return new View($res, Response::HTTP_NOT_FOUND);
        } else {
            $data['error'] = "Access denied! You dont have username or password!";
            return new View($data, Response::HTTP_NOT_FOUND);
        }
        #return $this->render('ShopBundle:Default:index.html.twig');
    }


    /**
     * @Rest\Get("/api/orders")
     * @param Request $request
     * @return array|View
     */
    public function getOrdersAction(Request $request)
    {
        $token = $request->get('token');
//        $password = $request->get('password');
//        $username = $request->get('username');
        $date = $request->get('date');
        if ($token) {
            $res = $this->tokenAuth($token, 'order');
            return new View($res, Response::HTTP_NOT_FOUND);
        }
        #return $this->render('ShopBundle:Default:index.html.twig');
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
     * @return mixed
     */

    public function tokenAuth($token, $name)
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
     * @param $date
     * @return mixed
     */
    private function order($date)
    {

        $restresult = $this->getDoctrine()->getRepository(OrdersInfo::class)->findBy($date);
        if ($restresult === null) {
            return new View("there are no orders exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }


}



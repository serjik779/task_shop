<?php

namespace Login\LoginBundle\Controller;

//use Login\LoginBundle\Entity\Users;
//use Login\LoginBundle\Entity\Roles;

use ShopBundle\Entity\Users;
use ShopBundle\Entity\Roles;

use ShopBundle\ShopBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Login\LoginBundle\Modals\Login;


class DefaultController extends Controller
{
    /**
     * @Route("/log")
     */
    public function indexAction(Request $request)
    {
        $session=$this->getRequest()->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ShopBundle:Users');
//        dump($repository);
        if ($request->getMethod()=='POST'){

            $session->clear();
            $email=$request->get('email');
            $password=$request->get('password');





            $user = $repository->findOneBy(array('email'=>$email, 'password'=>$password));
//        dump($_POST);

            if ($user) {
                $login = new Login();
                $login->setEmail($email);
                $login->setPassword($password);
                $session->set('login',$login);


//                    dump($login);

//                return $this->render('LoginLoginBundle:Default:welcome.html.twig', array('user' => $user));
                return $this->render('ShopBundle:home:index.html.twig', array('user' => $user));
            }else{
                return $this->render('ShopBundle:home:index.html.twig', array('name' => 'Login Failed'));
            }
        }else{
            if ($session->has('login')){
                $login = $session->get('login');
                $email = $login->getEmail();
                $password = $login->getPassword();
                $user = $repository->findOneBy(array('email'=>$email, 'password'=>$password));
                if ($user) {
                    return $this->render('ShopBundle:home:index.html.twig', array('user' => $user));
                }

            }
//            return $this->render('LoginLoginBundle:Default:login.html.twig');
            return $this->render('ShopBundle:home:index.html.twig');
        }

//        return $this->render('ShopBundle:home:index.html.twig');
    }

    /**
     * @Route("/signup")
     */
    public  function signupAction(Request $request){
        if ($request->getMethod()=='POST') {

            $email=$request->get('email');
            $password=$request->get('password');
            $name=$request->get('name');
            $address=$request->get('address');
            $phone=$request->get('phone');
//            $role='user';
            $em=$this->getDoctrine()->getEntityManager();

            $role = $em->getRepository(Roles::class)->findOneBy(array('type' => 'user'));
//            $role->setType('user');
//            $em->persist($role);
//            $em->flush();
dump($role);
            $user = new Users();
            $user->setEmail($email)
                 ->setPassword($password)
                 ->setName($name)
                 ->setAddress($address)
                 ->setPhone($phone)
                 ->setRole($role);

            $em=$this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

        }
//        return $this->render('LoginLoginBundle:Default:signup.html.twig');
//        return $this->render('ShopBundle:Default:index.html.twig');
        return $this->render('ShopBundle:home:index.html.twig');
    }




    /**
     * @Route("/logout")
     */
    public  function logoutAction(Request $request){
        $session=$this->getRequest()->getSession();
        $session->clear();
        return $this->render('ShopBundle:home:index.html.twig');
    }


    /**
     * @Route("/show")
     */
    public  function showAction(Request $request){


        $session=$this->getRequest()->getSession();
        $login = $session->get('login');
        dump($login);


        $session=$this->getRequest()->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('ShopBundle:Users');

        $login = $session->get('login');
        $email = $login->getEmail();
        $password = $login->getPassword();
        $user = $repository->findOneBy(array('email'=>$email, 'password'=>$password));


dump($login);
//        dump($user);
//print_r($user);
        return $this->render('ShopBundle:home:index.html.twig', array('user' => $user));
    }

}

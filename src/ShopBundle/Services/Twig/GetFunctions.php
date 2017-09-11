<?php

namespace ShopBundle\Services\Twig;


use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Cart;
use ShopBundle\Entity\CartItems;
use ShopBundle\Entity\Categories;
use Symfony\Component\Security\Core\SecurityContext;

class GetFunctions extends \Twig_Extension
{
    private $em;
    private $context;

    public function __construct(EntityManager $em, SecurityContext $context)
    {
        $this->em = $em;
        $this->context = $context;
    }

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions() {
        $o = $this;

        return array(
            'categories' => new \Twig_SimpleFunction('getCategories', function () use ($o) {
                return $o->getCategories();
            }),
            'countCartItems' => new \Twig_SimpleFunction('getCountCartItems', function () use ($o) {
                return $o->getCountCartItems();
            })
        );
    }

    public function getCountCartItems() {
        $user = $this->context->getToken()->getUser();
        $cart = $this->em->getRepository(Cart::class)->findBy(array('user' => $user));
        $cartItems = $this->em->getRepository(CartItems::class)->findBy(array('cart' => $cart));

        $cash = 0;
        foreach ($cartItems as $cartItem) {
            $cash += $cartItem->getProduct()->getCost() * $cartItem->getAmount();
        }

        return array('count' => count($cartItems), 'cash' => $cash);
    }

    public function getCategories()
    {
        $categories = $this->em->getRepository(Categories::class)->findAll();

        return $categories;
    }
}
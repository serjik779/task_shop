<?php

namespace ShopBundle\Services\Twig;


use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Categories;

class GetCategories extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
            })
        );
    }

    public function getCategories()
    {

        $categories = $this->em->getRepository(Categories::class)->findAll();

        return $categories;
    }
}
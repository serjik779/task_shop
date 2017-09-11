<?php

namespace ShopBundle\Services;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\View\View;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Images;
use ShopBundle\Entity\Products;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddingProductsCenter {

    private $container;

    public function __construct(ContainerInterface $container, EntityManager $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;

        $this->serviceUrl = $this->container->getParameter('service_url');
        $this->token = false;

        $token = $this->getServiceContents('/api/amount', [
            'username' => 'ustora',
            'password' => '123123',
        ]);
        if (!empty($token->token)) {
            $this->token = $token->token;
        }

    }

    public function getServiceContents($resource, array $parameters = array()) {
        $context = stream_context_create([
            'http' => [
                'method' => 'get',
                'header' => implode('\r\n', [
                    'Accept: */*',
                ]),
                'ignore_errors' => true,
                'timeout' => 20,
            ],
        ]);

        $url = $resource;
        if (!empty($parameters)) {
            foreach ($parameters as $key => &$value) {
                $value = "$key=$value";
            }

            $url .= '?' . implode('&', $parameters);
        }

        $content = file_get_contents($this->serviceUrl . $url, false, $context);

        return json_decode($content);
    }

    /**
     * Updates categories and related products from the remote source.
     *
     * @return bool
     */
    public function updateProducts()
    {
        $categories = $this->getServiceContents('/api/products', [
            'token' => $this->token,
        ]);

        if (empty($categories)){
            return false;
        }

        foreach($categories as $category) {
            $this->addCategory($category);
        }

        $this->entityManager->flush();

        return true ;
    }

    /**
     * Adds a category entity based on an array descriptor.
     *
     * @return bool|Categories
     */
    private function addCategory($categoryFields) {
        if (empty($categoryFields->id)) {
            return false;
        }

        $category = $this->entityManager
            ->getRepository('ShopBundle:Categories')
            ->findOneBy([
                'serviceId' => $categoryFields->id,
            ]);

        if (empty($category)) {
            $category = new Categories();
        }

        $products = [];
        if (!empty($categoryFields->products_in_category)) {
            $products = $categoryFields->products_in_category;
        }

        $category->setServiceId($categoryFields->id);
        $category->setTitle($categoryFields->title);

        $this->entityManager->persist($category);
        $this->entityManager->flush($category);

        foreach ($products as $product) {
            $this->addProduct($category, $product);
        }

        return $category;
    }

    /**
     * Appends a product to a category entity.
     *
     * @param Categories $category
     * @param $productFields
     */
    private function addProduct(Categories $category, $productFields) {
        $product = $this->entityManager
            ->getRepository('ShopBundle:Products')
            ->findOneBy([
                'serviceId' => $productFields->id,
            ]);

        if (empty($product)) {
            $product = new Products();
        }

        $product->setServiceId($productFields->id);
        $product->setTitle($productFields->title);
        $product->setDescription($productFields->description);
        $product->setCost($productFields->cost);
        $product->setCreated(new \DateTime($productFields->created));

        $this->entityManager->persist($product);

        $category->addProducts($product);
    }

    public function setCount() {
        $amounts = json_decode(file_get_contents("php://input"), true);
        $amounts = json_decode('{"0":{"id":1,"amount":32},"1":{"id":2,"amount":23},"2":{"id":3,"amount":23},"3":{"id":4,"amount":32}}');
        if (empty($amounts)) {
            return 'error';
        }
        $test = '';
        foreach ($amounts as $amount) {
            $test .= $amount['id'];
            $product = $this->entityManager
                ->getRepository(Products::class)
                ->findOneBy(array('serviceId' => $amount['id']));
            if (!empty($product)) {
                $product->setAmount($amount['amount']);
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $test .= $amount['amount'];
            }
        }
        return 'success' . $test;
    }
}

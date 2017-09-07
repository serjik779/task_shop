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

class AddingProductsCenter{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addProduct()
    {
        $serviceUrl = $this->container->getParameter('service_url');
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $context = stream_context_create([
            'http' => [
                'method' => 'get',
                'header' => implode('\r\n', [
                    'Accept: */*',
                ]),
                'ignore_errors' => true,
            ],
        ]);

        $token = file_get_contents($serviceUrl . '/api/amount?username=ustora&password=123123', false, $context);
        $token = json_decode($token,true);

        $products = file_get_contents($serviceUrl . '/api/products?token='.$token['token'], false, $context);
        $products = json_decode($products, true);

        if (empty($products)) {
            return 'Invalid json';
        }
        $url = 'http://img.yandex.net/i/www/logo.png';
        $path = './images/logo.png';
        for ($index = 0; $index < count($products); $index ++) {
            $categoryById = $em->getRepository(Categories::class)->findOneBy(['serviceId' => $products[$index]['id']]);
            if ($categoryById == null ) {
                $categoryById = new Categories();
                $imageOfCategory = new Images();
                $imageOfCategory->setFilename($products[$index]['image_name'])
                    ->refreshUpdated();
                $this->download($serviceUrl . '/images/category/' . $products[$index]['image_name'],$imageOfCategory->getWebPath());
                $categoryById->setTitle($products[$index]['title'])
                    ->setServiceId($products[$index]['id'])
                    ->setImage($imageOfCategory);
                $em->persist($imageOfCategory);
                $em->persist($categoryById);
                $em->flush();
            }
            for ($key = 0; $key < count($products[$index]['products_in_category']); $key ++) {
                $productById = $em->getRepository(Products::class)->findOneBy(['serviceId' => $products[$index]['products_in_category'][$key]['id']]);
                if ($productById == null) {
                    $productById = new Products();
                    $imageOfProduct = new Images();
                    $imageFileWithoutSpace = str_ireplace(' ', '-', $products[$index]['products_in_category'][$key]['image_name']);
                    $imageOfProduct->setFilename($imageFileWithoutSpace)
                        ->refreshUpdated();
                    $imageFile = $products[$index]['products_in_category'][$key]['image_name'];
                    $this->download($serviceUrl . '/images/products/' . $imageFile , $imageOfProduct->getWebPath());

                    $productById->setCategory($categoryById)
                        ->setTitle($products[$index]['products_in_category'][$key]['title'])
                        ->setDescription($products[$index]['products_in_category'][$key]['description'])
                        ->setCost($products[$index]['products_in_category'][$key]['cost'])
                        ->setServiceId($products[$index]['products_in_category'][$key]['id'])
                        ->addImage($imageOfProduct);

                    $em->persist($productById);
                    $em->persist($imageOfProduct);
                    $em->flush();
                }
            }
        }

        return 'Success' ;
    }

    public function download($url, $urlTo) {
        $ch = curl_init($url);
        $fp = fopen($urlTo, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    public function setCount($json = array()) {
        $amounts = empty($json) ?  : $json;

        if (empty($json)) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'get',
                    'header' => implode('\r\n', [
                        'Accept: */*',
                    ]),
                    'ignore_errors' => true,
                ],
            ]);
            $serviceUrl = $this->container->getParameter('service_url');
            $token = file_get_contents($serviceUrl . '/api/amount?username=ustora&password=123123', false, $context);
            $token = json_decode($token, true);

            $amounts = file_get_contents($serviceUrl . '/api/amount?token=' . $token['token'], false, $context);
            $amounts = json_decode($amounts, true);
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        foreach ($amounts as $amount) {
            $product = $em->getRepository(Products::class)->findOneBy(array('serviceId' => $amount['id']));
            if (!empty($product)) {
                $product->setAmount($amount['amount']);
                $em->persist($product);
                $em->flush();
            }
        }
    }
}
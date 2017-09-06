<?php

namespace ShopBundle\Services;

use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Images;
use ShopBundle\Entity\Products;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddingProductsCenter{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addProductAction(Request $request, $serviceUrl)
    {
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
            return new Response("Invalid json");
        }
        $url = 'http://img.yandex.net/i/www/logo.png';
        $path = './images/logo.png';
        for ($index = 0; $index < count($products); $index ++) {
            $categoryById = $this->em->getRepository(Categories::class)->findOneBy(['id' => $products[$index]['id']]);
            if ($categoryById == null ) {
                $categoryById = new Categories();
                $imageOfCategory = new Images();
                $imageOfCategory->setFilename($products[$index]['image_name'])
                    ->refreshUpdated();
                $this->download($serviceUrl . '/images/category/' . $products[$index]['image_name'],$imageOfCategory->getWebPath());
                $categoryById->setTitle($products[$index]['title'])
                    ->setImage($imageOfCategory);
                $this->em->persist($imageOfCategory);
                $this->em->persist($categoryById);
                $this->em->flush();
            }
            for ($key = 0; $key < count($products[$index]['products_in_category']); $key ++) {
                $productById = $this->em->getRepository(Products::class)->findOneBy(['id' => $products[$index]['products_in_category'][$key]['id']]);
                if ($productById == null) {
                    $productById = new Products();
                    $imageOfProduct = new Images();
                    $imageOfProduct->setFilename($products[$index]['products_in_category'][$key]['image_name'])
                        ->refreshUpdated();
                    $imageFile = str_replace(' ', '-', $products[$index]['products_in_category'][$key]['image_name']);
                    $this->download($serviceUrl . '/images/products/' . $imageFile , $imageOfProduct->getWebPath());

                    $productById->setCategory($categoryById)
                        ->setTitle($products[$index]['products_in_category'][$key]['title'])
                        ->setDescription($products[$index]['products_in_category'][$key]['description'])
                        ->setCost($products[$index]['products_in_category'][$key]['cost'])
                        ->setServiceId($products[$index]['products_in_category'][$key]['id'])
                        ->addImage($imageOfProduct);

                    $this->em->persist($productById);
                    $this->em->persist($imageOfProduct);
                    $this->em->flush();
                }
            }
        }

        return 'success';
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
}
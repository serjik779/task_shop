<?php


namespace ShopBundle\ViewModels\Categories;

use gotakk\ViewModelBundle\ViewModel\ViewModelAssembler;

use ShopBundle\Entity\Categories;
class AllCategoriesViewModelAssembler extends ViewModelAssembler
{
    public function __construct()
    {
        $this->skel = array(
            'CategoryName' => array(),
            'Image',
        );
    }

    public function generateViewModel($model)
    {
        $vm = $this->vmService->createViewModel();

        $vm->setPageTitle('Contact Us');
        $vm->addMail('abc@gmail.com');
        $vm->addMail('def@gmail.com');

        return $vm->toArray();
    }
}
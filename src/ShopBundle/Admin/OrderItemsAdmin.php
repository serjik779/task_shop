<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;

use ShopBundle\Entity\OrdersInfo;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderItemsAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('ordersInfo', EntityType::class, array(
                'class' => OrdersInfo::class
            ))
            ->add('products', ModelType::class)
            ->add('discount', NumberType::class)
            ->add('amount', NumberType::class);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('ordersInfo')
            ->add('products')
            ->add('discount')
            ->add('amount');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('ordersInfo')
            ->addIdentifier('products')
            ->addIdentifier('discount')
            ->addIdentifier('amount');
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('ordersInfo')
            ->add('products')
            ->add('discount')
            ->add('amount');
    }
}
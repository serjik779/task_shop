<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;

use ShopBundle\Entity\DeliveryType;
use ShopBundle\Entity\OrdersInfo;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class OrderItemsAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('ordersInfo', EntityType::class, array(
                'class' => OrdersInfo::class
            ))
            ->add('deliveryType', EntityType::class, array(
                'class' => DeliveryType::class
            ))
            ->add('products', ModelListType::class, array(
                'compound' => true,
                'by_reference' => true), array(
                'placeholder' => 'No product selected',
                'multiple' => true
            ))
            ->add('discount', PercentType::class)
            ->add('amount', NumberType::class);
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('discount');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('discount');
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('discount');
    }

//    public function prePersist($orderInfo)
//    {
//        $this->preUpdate($orderInfo);
//    }
//
//    public function preUpdate($orderInfo)
//    {
//        $orderInfo->setOrderItems($orderInfo->getOrderItems());
//    }
//    public function prePersist($page)
//    {
//        $this->manageEmbeddedImageAdmins($page);
//    }
//
//    public function preUpdate($page)
//    {
//        $this->manageEmbeddedImageAdmins($page);
//    }
//
//    private function manageEmbeddedImageAdmins($page)
//    {
//        // Cycle through each field
//        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
//            // detect embedded Admins that manage Images
//            if ($fieldDescription->getType() === 'sonata_type_admin' &&
//                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
//                $associationMapping['targetEntity'] === 'ShopBundle\Entity\Images'
//            ) {
//                $getter = 'get'.$fieldName;
//                $setter = 'set'.$fieldName;
//
//                /** @var Images $image */
//                $image = $page->$getter();
//
//                if ($image) {
//                    if ($image->getFile()) {
//                        // update the Image to trigger file management
//                        $image->refreshUpdated();
//                    } elseif (!$image->getFile() && !$image->getFilename()) {
//                        // prevent Sf/Sonata trying to create and persist an empty Image
//                        $page->$setter(null);
//                    }
//                }
//            }
//        }
//    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;


use Doctrine\DBAL\Types\TextType;
use Doctrine\Entity;
use ShopBundle\Entity\Categories;
use ShopBundle\Entity\Images;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OrderInfoAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('date', 'datetime')
            ->add('address', 'text')
            ->add('phone', 'text')
            ->add('name', 'text')
            ->add('orderItems', 'sonata_type_collection', array(
                'required' => false
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
        ;
            #->add('image', 'sonata_type_admin', array( 'label' => false, 'delete' => false ));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name');
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name');
    }

//    public function prePersist($ordersInfo)
//    {
//        $this->preUpdate($ordersInfo);
//    }
//
//    public function preUpdate($ordersInfo)
//    {
//        $ordersInfo->setOrderItems($ordersInfo->getOrderItems());
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
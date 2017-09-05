<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14.08.2017
 * Time: 7:56
 */

namespace ShopBundle\Admin;

use ShopBundle\Entity\Slider;
use ShopBundle\Entity\Images;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SliderAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', AdminType::class, array(
                'label' => false,
                'delete' => false
            ))
            ->add('name', TextType::class)
            ->add('description', SimpleFormatterType::class, array(
                'format' => 'richhtml', 'attr' => array(
                    'class' => 'ckeditor')));
    }


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('image')
            ->add('name')
            ->add('description');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('image')
            ->addIdentifier('name')
            ->addIdentifier('description');

    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('image')
            ->add('name')
            ->add('description');
    }

    public function prePersist($slider)
    {
        $this->manageEmbeddedImageAdmins($slider);
    }

    public function preUpdate($slider)
    {
        $this->manageEmbeddedImageAdmins($slider);
    }

    private function manageEmbeddedImageAdmins($slider)
    {
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            if ($fieldDescription->getType() === 'Sonata\CoreBundle\Form\Type\CollectionType' &&
                ($associationMapping = $fieldDescription->getAssociationMapping()) &&
                $associationMapping['targetEntity'] === 'ShopBundle\Entity\Images'
            ) {
                $getter = 'get' . $fieldName;
                $setter = 'set' . $fieldName;
                if ($slider->getImages()) {
                    foreach ($slider->getImages() as $image) {
                        if ($image->getFile()) {
                            $image->refreshUpdated();
                        } elseif ((!$image->getFile()) && (!$image->getFilename())) {
                            $slider->$setter(null);
                        }
                    }
                }
            }
        }
    }
}

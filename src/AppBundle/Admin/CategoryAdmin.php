<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', 'text',[
                    'label' => '标题',
                ])
                ->add('parent', 'sonata_type_model', [
                    'label' => '父栏目',
                    'required' => false,
                ])
                ->add('status', 'checkbox', [
                    'label' => '是否有效',
                ])
                ->add('data', 'textarea', [
                    'label' => '其他数据',
                    'required' => false,
                ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name')
            ->add('parent')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('parent')
            ->addIdentifier('name')
        ;
    }
}
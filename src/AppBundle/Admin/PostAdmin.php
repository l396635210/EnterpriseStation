<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with("文章", ['class' => 'col-md-9'])
                ->add('title', 'text',[
                    'label' => '标题',
                ])
                ->add('category', 'sonata_type_model', [
                    'label' => '栏目',
                    'required' => true,
                ])
                ->add('body', 'ckeditor', [
                    'label' => '内容',
                    'required' => true,
                ])
                ->add('status', 'checkbox', [
                    'label' => '是否有效',
                ])
            ->end()
            ->with("源数据", ['class' => 'col-md-3'])
                ->add('data', 'textarea', [
                    'label' => '其他数据',
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('category')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('category')
            ->addIdentifier('title')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('category')
            ->add('body')
        ;
    }
}
<?php

namespace Cogitoweb\ParametersBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ParameterAdmin extends Admin
{
    protected $datagridValues = [
		'_sort_by'    => 'key',
		'_sort_order' => 'ASC'
	];
	
	/**
	 * {@inheritdoc}
	 */
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection->remove('batch');
	}
	
	/**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('key')
            ->add('value')
            ->add('deletable')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
			->remove('batch')
			
            ->add('key')
            ->add('value')
            ->add('deletable')
            ->add('_action', 'actions', array(
				'template' => 'CogitowebParametersBundle:CRUD:list__action.html.twig',
				'actions'  => array(
	                'show'   => array(),
		            'edit'   => array(),
			        'delete' => array('template' => 'CogitowebParametersBundle:CRUD:list__action_delete.html.twig'),
				)
			))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('key', null, ['read_only' => !$this->isNew()])
            ->add('value')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('key')
            ->add('value')
            ->add('deletable')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
	
	/**
	 * Is object new? 
	 *
	 * @return bool
	 */
	protected function isNew()
	{
		return ($this->getRoot()->getSubject() && $this->getRoot()->getSubject()->getId()) ? false : true;
	}
}

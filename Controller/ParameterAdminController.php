<?php

namespace Cogitoweb\ParametersBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ParameterAdminController extends CRUDController
{
	/**
	 * {@inheritdoc}
	 */
	public function deleteAction($id)
	{
		/*
		 * Code is extended to check delete permission based on object's "deletable" property
		 */
		$id = $this->get('request')->get($this->admin->getIdParameter());
		$object = $this->admin->getObject($id);

		if (!$object) {
			throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
		}

		if (!$object->getDeletable()) {
			throw new AccessDeniedException();
		}
		
		return parent::deleteAction($id);
	}
}
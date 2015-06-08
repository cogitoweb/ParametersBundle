<?php

namespace Cogitoweb\ParametersBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

/**
 * Description of ParametersService
 *
 * @author Daniele Artico <daniele.artico@cogitoweb.it>
 */
class ParametersService
{
	protected $em;
	protected $cache;
	protected $cacheUpdated;
	
	/**
	 * Construct
	 * 
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager) {
		$this->em           = $entityManager;
		$this->cache        = [];
		$this->cacheUpdated = false;
	}
	
	/**
	 * Get parameter
	 * 
	 * @param string $key
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function getParameter($key)
	{
		// On first run, update cache
		if (!$this->cacheUpdated) {
			$this->updateCache();
		}
		
		// Check if requested parameter exists
		if (!array_key_exists($key, $this->cache)) {
			throw new \InvalidArgumentException(
				sprintf('Parameter "%s" does not exist', $key)
			);
		}
		
		return $this->cache[$key];
	}
	
	/**
	 * Cache all parameters set in the database table
	 * 
	 * @return \Cogitoweb\ParametersBundle\Services\ParametersService
	 */
	private function updateCache()
	{
		$q = $this->em->createQuery('SELECT p.key, p.value FROM CogitowebParametersBundle:Parameter p INDEX BY p.key');
		
		$this->cache = array_map(
			function($param) {
				return $param['value'];
			},
			$q->getResult(Query::HYDRATE_ARRAY)
		);
		
		$this->cacheUpdated = true;
		
		return $this;
	}
}
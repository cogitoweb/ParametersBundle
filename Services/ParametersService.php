<?php

namespace Cogitoweb\ParametersBundle\Services;

use Cogitoweb\ParametersBundle\Entity\Parameter;
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
     * Set parameter
     *
     * @param string $key
     * @param string $value
     */
    public function setParameter($key, $value)
    {
        // On first run, update cache
        if (!$this->cacheUpdated) {
            $this->updateCache();
        }

        if (array_key_exists($key, $this->cache)) {
            $q = $this->em->createQuery('UPDATE CogitowebParametersBundle:Parameter p SET p.value = :value WHERE p.key = :key');
            $q->setParameter('key', (string) $key);
            $q->setParameter('value', (string) $value);
            $q->execute();
        } else {
            $parameter = new Parameter();
            $parameter->setKey((string) $key);
            $parameter->setValue((string) $value);

            $this->em->persist($parameter);
            $this->em->flush($parameter);
        }

        $this->updateCache();
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

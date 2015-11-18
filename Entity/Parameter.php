<?php

namespace Cogitoweb\ParametersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Parameter
 *
 * @author Daniele Artico <daniele.artico@cogitoweb.it>
 */

/**
 * @ORM\Table(name="cogitoweb_parameters_bundle",
 *	uniqueConstraints={
 *		@ORM\UniqueConstraint(
 *			name="IDX_cogitoweb_parameters_bundle_key", 
 *			columns={"key"}
 *		)
 *	})
 * @ORM\Entity
 * @UniqueEntity("key")
 */
class Parameter {
	use BlameableEntity;
    use TimestampableEntity;
	
	/**
	 *
	 * @var integer
	 * 
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 *
	 * @var string
	 * 
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(max=255)
	 * @Assert\NotNull();
	 */
	protected $key;
	
	/**
	 *
	 * @var boolean
	 * 
	 * @ORM\Column(type="boolean", options={"default": false})
	 * @Assert\NotNull()
	 */
	protected $deletable = false;
	
	/**
	 *
	 * @var string
	 * 
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $value;
	
	public function __toString() {
		return $this->getKey() ? : '';
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return Parameter
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set deletable
     *
     * @param  boolean $deletable
     * @return Parameter
     */
    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;

        return $this;
    }

    /**
     * Get deletable
     *
     * @return boolean 
     */
    public function getDeletable()
    {
        return $this->deletable;
    }
}

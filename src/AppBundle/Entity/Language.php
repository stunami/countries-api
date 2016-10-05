<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Language
 *
 * @ORM\Table(name="country_languages")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
final class Language
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2)
     * @Serializer\Expose()
     */
    private $code;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="languages")
     */
    private $country;


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
     * Set code
     *
     * @param string $code
     * @return Language
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}

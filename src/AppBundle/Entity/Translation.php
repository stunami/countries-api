<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Translation
 *
 * @ORM\Table(name="country_translations")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
final class Translation
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
     * @ORM\Column(name="language", type="string", length=255)
     * @Serializer\Expose()
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     * @Serializer\Expose()
     */
    private $translation;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="translations")
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
     * Set language
     *
     * @param string $language
     * @return Translation
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set translation
     *
     * @param string $translation
     * @return Translation
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
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

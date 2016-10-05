<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CountryRepository")
 * @Serializer\ExclusionPolicy("all")
 */
final class Country
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="top_level_domain", type="string", length=3)
     * @Serializer\Expose()
     */
    private $topLevelDomain;

    /**
     * @var string
     *
     * @ORM\Column(name="iso2_code", type="string", length=2)
     * @Serializer\Expose()
     */
    private $iso2Code;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code3", type="string", length=3)
     * @Serializer\Expose()
     */
    private $iso3Code;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     * @Serializer\Expose()
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     * @Serializer\Expose()
     */
    private $longitude;

    /**
     * @var ArrayCollection<Language>.
     *
     * @ORM\OneToMany(targetEntity="Language", mappedBy="country")
     * @Serializer\Expose()
     */
    private $languages;

    /**
     * @var ArrayCollection<Translation>.
     *
     * @ORM\OneToMany(targetEntity="Translation", mappedBy="country")
     * @Serializer\Expose()
     */
    private $translations;

    /**
     * @var ArrayCollection<Country>.
     *
    /**
     * @ORM\ManyToMany(targetEntity="Country")
     * @ORM\JoinTable(name="neighbours",
     *     joinColumns={@ORM\JoinColumn(name="country_a_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="country_b_id", referencedColumnName="id")}
     * )
     * @Serializer\Expose()
     * @Serializer\Accessor(getter="getNeighbourIso3Code")
     * @Serializer\Type("array")
     */
    private $neighbours;

    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->neighbours = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set topLevelDomain
     *
     * @param string $topLevelDomain
     * @return Country
     */
    public function setTopLevelDomain($topLevelDomain)
    {
        $this->topLevelDomain = $topLevelDomain;

        return $this;
    }

    /**
     * Get topLevelDomain
     *
     * @return string 
     */
    public function getTopLevelDomain()
    {
        return $this->topLevelDomain;
    }

    /**
     * @return string
     */
    public function getIso2Code()
    {
        return $this->iso2Code;
    }

    /**
     * @param string $iso2Code
     */
    public function setIso2Code($iso2Code)
    {
        $this->iso2Code = $iso2Code;
    }

    /**
     * @return string
     */
    public function getIso3Code()
    {
        return $this->iso3Code;
    }

    /**
     * @param string $iso3Code
     */
    public function setIso3Code($iso3Code)
    {
        $this->iso3Code = $iso3Code;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Country
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Country
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function addTranslation(Translation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);

            $translation->setCountry($this);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    public function addLanguage(Language $language)
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);

            $language->setCountry($this);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    public function addNeighbour(Country $country)
    {
        if (!$this->neighbours->contains($country)) {
            $this->neighbours->add($country);
            $country->addNeighbour($this);

        }
    }

    /**
     * @return mixed
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }

    /**
     * @return array
     */
    public function getNeighbourIso3Code()
    {
        $codes = [];

        foreach ($this->neighbours as $neighbour) {
            $codes[] = $neighbour->getIso3Code();
        }

        return $codes;
    }
}

<?php

namespace  AppBundle\Model;

use AppBundle\Entity\Country;
use AppBundle\Entity\CountryRepository;
use AppBundle\Entity\Language;
use AppBundle\Entity\Translation;
use Doctrine\ORM\EntityManager;

class RestCountriesImporter
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var RestCountriesFetcher
     */
    private $fetcher;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * RestCountriesImporter constructor.
     * @param $fetcher
     */
    public function __construct(EntityManager $entityManager, RestCountriesFetcher $fetcher, CountryRepository $countryRepository)
    {
        $this->entityManager = $entityManager;
        $this->fetcher = $fetcher;
        $this->countryRepository = $countryRepository;
    }

    public function import()
    {
        $countries = $this->fetcher->fetch();

        $this->handleCountry($countries);
        $this->handleNeighbours($countries);
    }

    /**
     * @param $countries
     * @return array
     */
    private function handleCountry($countries)
    {
        foreach ($countries as $data) {

            if ($data['alpha3Code']) {
                $country = $this->countryRepository->findOneBy(
                    [
                        'iso3Code' => $data['alpha3Code']
                    ]
                );

                $country = $country ?: new Country();

                $country->setName($data['name']);
                $country->setIso2Code($data['alpha2Code']);
                $country->setIso3Code($data['alpha3Code']);

                $country->setTopLevelDomain(current($data['topLevelDomain']));

                if (!empty($data['latlng'])) {
                    $country->setLatitude($data['latlng'][0]);
                    $country->setLongitude($data['latlng'][1]);
                }

                if (isset($data['translations'])) {
                    $this->handleTranslations($country, $data['translations']);
                }

                if (isset($data['languages'])) {
                    $this->handleLanguages($country, $data['languages']);
                }

                $this->entityManager->persist($country);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param $country
     * @param $data
     */
    private function handleTranslations(Country $country, array $data)
    {
        $translations = $country->getTranslations();

        foreach ($data as $language => $text) {

            $text = trim($text);
            if (empty($text)) {
                continue;
            }

            $current = null;
            foreach ($translations as $translation) {

                /**
                 * Existing
                 */
                if ($language == $translation->getLanguage()) {
                    $translation->setTranslation($text);

                    $current = $translation;

                    continue;
                }
            }

            /**
             * New
             */
            if (!$current) {

                $new = new Translation();
                $new->setLanguage($language);
                $new->setTranslation($text);

                $country->addTranslation($new);

                $this->entityManager->persist($new);
            }

            /**
             * @todo Handle removed translations
             */
        }
    }

    /**
     * @param $country
     * @param $data
     */
    private function handleLanguages(Country $country, array $data)
    {
        $languages = $country->getLanguages();

        foreach ($data as $code) {

            $code = trim($code);
            if (empty($code)) {
                continue;
            }

            $current = false;
            foreach ($languages as $language) {

                /**
                 * Existing
                 */
                if ($code == $language->getCode()) {
                    $current = true;
                    continue;
                }
            }

            /**
             * New
             */
            if (!$current) {
                $new = new Language();
                $new->setCode($code);

                $country->addLanguage($new);

                $this->entityManager->persist($new);
            }

            /**
             * @todo Handle removed langauges
             */
        }
    }

    private function handleNeighbours(array $countries)
    {
        foreach ($countries as $data) {
            $country = $this->countryRepository->findOneBy(
                [
                    'iso3Code' => $data['alpha3Code']
                ]
            );

            foreach ($data['borders'] as $border) {
                $neighbour = $this->countryRepository->findOneBy(
                    [
                        'iso3Code' => $border
                    ]
                );

                $country->addNeighbour($neighbour);
            }
        }

        $this->entityManager->flush();
    }

}
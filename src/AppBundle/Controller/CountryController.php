<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CountryController extends Controller
{
    public function getCountryAction($iso2Code)
    {
        $country = $this->getDoctrine()->getRepository(Country::class)->findOneByIso2Code($iso2Code);

        return [$country];
    }

    public function getCountriesAction()
    {
        $filters = $this->getRequest()->query->all();

        $countries = $this->getDoctrine()->getRepository(Country::class)->findByFilters($filters);

        return array(
            $countries
        );
    }
    }

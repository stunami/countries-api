<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Country;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CountriesController extends Controller
{
    /**
     * @Route("/api/v1/countries")
     * @Template()
     */
    public function getAction()
    {
        $filters = $this->getRequest()->query->all();

        $countries = $this->getDoctrine()->getRepository(Country::class)->findByFilters($filters);

        return array(
            $countries
        );
    }
}

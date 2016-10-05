<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Cannibal\Bundle\FilterBundle\CannibalFilterBundle(),
            new Cannibal\Bundle\SortBundle\CannibalSortBundle(),
            new Cannibal\Bundle\PaginationBundle\CannibalPaginationBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir()
    {
        if(is_dir('/var/recombu/iws/cache') && in_array($this->getEnvironment(), array('dev', 'test'))){
            return '/var/recombu/iws/cache/'.$this->getEnvironment();
        }

        return parent::getCacheDir();
    }

    public function getLogDir()
    {
        if(is_dir('/var/recombu/iws/logs') && in_array($this->getEnvironment(), array('dev', 'test'))){
            return '/var/recombu/iws/logs';
        }

        return parent::getLogDir();
    }
}

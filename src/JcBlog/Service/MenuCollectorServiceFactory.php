<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JcBlog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JcBlog\Collector\MenuCollector;

/**
 * Factory responsible of instantiating {@see \BjyAuthorize\Collector\RoleCollector}
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class MenuCollectorServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \BjyAuthorize\Collector\RoleCollector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $identityProvider \BjyAuthorize\Provider\Identity\ProviderInterface */
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');

        return new MenuCollector($em);
    }
}

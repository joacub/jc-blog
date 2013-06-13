<?php

namespace JcBlog;

use Zend\ModuleManager;
use AtDataGrid\DataGrid\DataSource\DoctrineDbTableGateway;
use AtDataGrid\DataGrid\Renderer\Html;
use AtDataGrid\DataGrid\Manager;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ModuleManager\Feature\AutoloaderProviderInterface,
                        ModuleManager\Feature\ConfigProviderInterface,
                        ServiceProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
    			'jcblog_grid_datasource' => function ($sm) {
    				$dataSource = new DoctrineDbTableGateway(array(
    					'entity' => 'JcBlog\Entity\Post',
    					'em' => $sm->get('jcblog_doctrine_em'),
    				));
    				return $dataSource;
    			},
    			'jcblog_grid_renderer' => function (\Zend\ServiceManager\ServiceManager $sm) {
    				$renderer = new Html();
    				$renderer->setEngine($sm->get('ViewRenderer'))->setServiceManager($sm);
    				return $renderer;
    			},
    			'jcblog_grid' => function ($sm) {
    				$grid = new Grid\Post($sm->get('jcblog_grid_datasource'));
    				return $grid;
    			},
    			'jcblog_grid_manager' => function ($sm) {
    				try{
    				$manager = new Manager($sm->get('jcblog_grid'), $sm);
    				$manager->setRenderer($sm->get('jcblog_grid_renderer'));
    				} catch (\Exception $e) {
    					echo $e->getMessage();exit;
    				}
    				return $manager;
    			},
    		)
    	);
    }
}

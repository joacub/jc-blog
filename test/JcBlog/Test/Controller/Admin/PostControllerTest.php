<?php

use JcBlog\Controller\Admin_PostController;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\Application;
use Zend\ServiceManager\Config;

date_default_timezone_set('Europe/Madrid');

class Admin_PostControllerTest extends \PHPUnit_Framework_TestCase
{
	
	protected $controller;
	protected $request;
	protected $response;
	protected $routeMatch;
	protected $event;
	
	protected function setUp()
	{
		$this
		->setBootstrap(__DIR__ . '/../../../../bootstrap.php');
		$application = require $this->bootstrap;
		$this->application = $application;
		$this->sm = $application->getServiceManager();
		
		$serviceManager = $this->sm;
		$this->controller = new Admin_PostController();
		$this->request    = new Request();
		$this->routeMatch = new RouteMatch(array('controller' => 'JcBlog\Controller\Admin\Index'));
		$this->event      = new MvcEvent();
		$config = $serviceManager->get('Config');
		$app = $serviceManager->get('application');
		$app instanceof Application;
		$this->controller->setPluginManager(new PluginManager(new Config(array('invokables' => array(
                'backTo' => 'AtBase\Mvc\Controller\Plugin\BackTo'
            ),))));
		
		$routerConfig = isset($config['router']) ? $config['router'] : array();
		$router = HttpRouter::factory($routerConfig);
	
		$this->event->setRouter($router);
		$this->event->setRouteMatch($this->routeMatch);
		$this->controller->setEvent($this->event);
		$this->controller->setServiceLocator($serviceManager);
		
		
	}
	
	public function testIndexActionCanBeAccessed()
	{
	    $this->routeMatch->setParam('action', 'edit');
	    $this->routeMatch->setParam('id', '1');
	
	    $result   = $this->controller->dispatch($this->request);
	    $response = $this->controller->getResponse();
	
	    $this->assertEquals(200, $response->getStatusCode());
	}
	
	
	/**
	 * path to bootstrap file, which should return Zend\Mvc\Application
	 *
	 * @var string
	 */
	protected $bootstrap;
	protected function setBootstrap($bootstrap)
	{
		$this->bootstrap = $bootstrap;
	
		return $this;
	}
	
	/**
	 * ZF application instance
	 *
	 * @var Zend\Mvc\Application
	 */
	protected $application;
	
	/**
	 * ZF service manager instance
	 *
	 * @var Zend\ServiceManager\ServiceManager
	 */
	protected $sm;

	
    
}
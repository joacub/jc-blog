<?php 
use PHPUnit_Framework_TestCase as TestCase;  
use JcBlog\Entity\Post;
class PostTest extends TestCase  
{  
    protected $postService;  
    
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
    
    public function setup()  
    {  
    	$this
    	->setBootstrap(__DIR__ . '/../../../bootstrap.php');
    	$application = require $this->bootstrap;
    	$this->application = $application;
    	$this->sm = $application->getServiceManager();
    	
    }  
    public function testAnnotationBuilder()  
    {  
    	$formGeneretor = $this->sm->get('formGenerator');
    	
    	$formGeneretor->setClass(get_class(new Post()))
    	->getForm();
    	
    	$this->assertInstanceOf(
    			get_class($formGeneretor),
    			$formGeneretor);
       
    }  
    
    /**
     * start afresh
     *
     * @return void
     */
    public function tearDown()
    {
    	unset($this->application);
    	unset($this->sm);
    }
    
    public function testServiceManagerInstance()
    {
    	$this->assertInstanceOf(
    			'Zend\ServiceManager\ServiceManager',
    			$this->sm);
    }
}  
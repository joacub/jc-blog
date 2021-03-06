<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JcBlog\Collector;

use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;
use JcNavigation\Collector\AbstractEntityCollector;

/**
 * Role collector - collects the role during dispatch
 *
 * @author Johan Rodriguez <joacub@gmail.com>
 */
class MenuCollector extends AbstractEntityCollector
{
    const NAME     = 'jc_blog_pages_collector';
    
    const PRIORITY = 150;
    
    const ROUTER   = 'JcBlog-post';

    /**
     * @var array|string[] collected role ids
     */
    protected $collectedPages = array();

    /**
     * @var EntityManager
     */
    protected $em;
    
    protected $options;
    
    public function __construct(EntityManager $em, $options)
    {
    	$this->em = $em;
    	$this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return static::PRIORITY;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
        if (! $this->em) {
            return;
        }

        $posts = $this->em
        ->getRepository($this->options['entity_class'])
        ->findAll();

        foreach ($posts as $post) {
            if ($post) {
                $this->collectedPages[] = $post;
            }
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getEntity()
    {
    	return $this->options['entity_class'];
    }
    
    /**
     * {@inheritDoc}
     */
    public function getTitle($entity)
    {
    	return $entity->getTitle();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getRouter()
    {
    	return static::ROUTER;
    }
    
    public function getRouterParams($entity)
    {
        try {
            if(is_object($entity)) {
                $slug = $entity->getSlug();
            } else {
                $slug = '';
            }

        } catch(\Exception $e) {
            $slug = '';
        }
    	return array('slug' => $slug);
    }

    /**
     * @return array|string[]
     */
    public function getCollectedPages()
    {
        return $this->collectedPages;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->collectedPages);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->collectedPages = unserialize($serialized);
    }
}

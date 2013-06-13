<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JcBlog\Collector;

use Serializable;
use Zend\Mvc\MvcEvent;
use JcNavigation\Collector\CollectorInterface;
use Doctrine\ORM\EntityManager;

/**
 * Role collector - collects the role during dispatch
 *
 * @author Johan Rodriguez <joacub@gmail.com>
 */
class MenuCollector implements CollectorInterface, Serializable
{
    const NAME     = 'jc_blog_pages_collector';
    
    const PRIORITY = 150;
    
    const ENTITY   = 'JcBlog\Entity\Post';
    
    const ROUTER   = 'JcBlog-post';

    /**
     * @var array|string[] collected role ids
     */
    protected $collectedPages = array();

    /**
     * @var EntityManager
     */
    protected $em;
    
    public function __construct(EntityManager $em)
    {
    	$this->em = $em;
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
        ->getRepository('JcBlog\Entity\Post')
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
    	return static::ENTITY;
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
    	return array('slug' => $entity->getSlug());
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

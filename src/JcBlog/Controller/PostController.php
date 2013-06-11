<?php
namespace JcBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use JcBlog\Entity\Post;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class PostController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery('SELECT p FROM JcBlog\Entity\Post p ORDER BY p.created_at DESC, p.id DESC');

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setItemCountPerPage($this->getConfig('posts-per-page'));

        return array('posts' => $paginator, 'config' => $this->getConfig());
    }

    public function viewAction()
    {
        $slug = $this->params()->fromRoute('slug');

        $post = $this->getEntityManager()
                     ->getRepository('JcBlog\Entity\Post')
                     ->findOneBy(array('slug' => $slug))
        ;

        return array('post' => $post, 'config' => $this->getConfig());
    }

    /**
     * Console-only route to generate fixtures.
     */
    public function fixturesAction()
    {
        $em = $this->getEntityManager();

        for ($i = 0; $i < 100; $i++) {
            $post = new Post();
            $post->title = 'Post ' . uniqid();
            $post->intro = str_repeat('intro', rand(1, 100));
            for ($j = mt_rand(1, 100); $j > 0; $j--) {
                $post->content .= str_repeat('lorem ipsum ', rand(1, 20));
            }
            $em->persist($post);
        }
        $em->flush();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    protected function getConfig($key = null)
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $config = $config['JcBlog'];
        if ($key) {
            return $config[$key];
        } else {
            return $config;
        }
    }
}

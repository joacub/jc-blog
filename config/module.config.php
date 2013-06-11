<?php
namespace JcBlog;

return array(
    'JcBlog' => array(
        'posts-per-page' => 10,
        'date-format' => '%e %b %Y'
    ),
    'doctrine' => array(
        'driver' => array(
            'JcBlog_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => 'JcBlog_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'JcBlog' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/blog[/page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'JcBlog\Controller',
                        'controller'    => 'Post',
                        'action'        => 'index',
                        'page'          => 1
                    ),
                    'contraints' => array(
                        'page' => '[0-9]+'
                    )
                ),
            ),
            'JcBlog-post' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route' => '/blog/[:slug]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'JcBlog\Controller',
                        'controller'    => 'Post',
                        'action'        => 'view',
                    ),
                    'contraints' => array(
                        'slug' => '[A-z0-9-_]+'
                    )
                )
            )
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'JcBlog-fixtures' => array(
                    'type' => 'simple',
                    'options' => array(
                        'route' => 'blog fixtures',
                        'defaults' => array(
                            '__NAMESPACE__' => 'JcBlog\Controller',
                            'controller'    => 'Post',
                            'action'        => 'fixtures',
                        )
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'JcBlog\Controller\Post' => 'JcBlog\Controller\PostController'
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'JcBlog' => __DIR__ . '/../view',
        )
    )
);

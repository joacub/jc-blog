<?php
namespace JcBlog;
return array(
	'JcBlog' => array(
		'posts-per-page' => 10,
		'date-format' => '%e %b %Y',
	    'entity_class' => 'JcBlog\Entity\ByDefault\Post',
	    'enable_default_entities' => true,
	),
    'doctrine' => array(
        'driver' => array(
            'JcBlog_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/jcblog'
            ),
    
            'orm_default' => array(
                'drivers' => array(
                    'JcBlog\Entity\Super'  => 'JcBlog_entities'
                )
            )
        )
    ),
	'router' => array(
		'routes' => array(
			'zfcadmin' => array(
				'child_routes' => array(
					__NAMESPACE__ => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/' . __NAMESPACE__,
							'defaults' => array(
								'controller' => __NAMESPACE__ . '\Controller\Admin\Index',
								'action' => 'index',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'posts' => array(
								'type' => 'Segment',
								'options' => array(
									'route' => '/post[/:action[/:id]]',
									'defaults' => array(
										'controller' => __NAMESPACE__ . '\Controller\Admin\Post',
										'action' => 'index',
										'id' => 0,
									),
									'constraints' => array(
										'id' => '[0-9]+',
									),
								),
							),
						),
					),
				),
			),
			'JcBlog' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/blog[/page/:page]',
					'defaults' => array(
						'__NAMESPACE__' => 'JcBlog\Controller',
						'controller' => 'Post',
						'action' => 'index',
						'page' => 1
					),
					'contraints' => array(
						'page' => '[0-9]+'
					)
				)
			),
			'JcBlog-post' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/blog/[:slug]',
					'defaults' => array(
						'__NAMESPACE__' => 'JcBlog\Controller',
						'controller' => 'Post',
						'action' => 'view'
					),
					'contraints' => array(
						'slug' => '[A-z0-9-_]+'
					)
				)
			)
		)
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
							'controller' => 'Post',
							'action' => 'fixtures'
						)
					)
				)
			)
		)
	),
	'controllers' => array(
		'invokables' => array(
			'JcBlog\Controller\Post' => 'JcBlog\Controller\PostController',
			__NAMESPACE__ . '\Controller\Admin\Index' => __NAMESPACE__ . '\Controller\Admin_IndexController',
			__NAMESPACE__ . '\Controller\Admin\Post' => __NAMESPACE__ . '\Controller\Admin_PostController',
		),
	),
	'navigation' => array(
		'admin' => array(
			'post' => array(
				'label' => 'Páginas',
				'route' => 'zfcadmin/' . __NAMESPACE__ . '/posts',
				'pages' => array(
					'post-list' => array(
						'label' => 'Listado de páginas',
						'route' => 'zfcadmin/' . __NAMESPACE__ . '/posts',
						'params' => array('action' => 'list'),
						'pages' => array(
							'articles-create' => array(
								'label' => 'Nueva página',
								'route' => 'zfcadmin/' . __NAMESPACE__ . '/posts',
								'params' => array('action' => 'create'),
							),
						)
					),
					'post-create' => array(
						'label' => 'Nueva página',
						'route' => 'zfcadmin/' . __NAMESPACE__ . '/posts',
						'params' => array('action' => 'create'),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'JcBlog' => __DIR__ . '/../view'
		),
		'template_map' => array(
			'jc-navigation/toolbar/jc-blog-pages'
			=> __DIR__ . '/../view/jc-navigation/toolbar/jc-blog-pages.phtml',
		),
	),
	
	'service_manager' => array(
		'factories' => array(
			'JcBlog\Collector\MenuCollector'  => 'JcBlog\Service\MenuCollectorServiceFactory',
		),
		'aliases' => array(
			'jcblog_doctrine_em' => 'Doctrine\ORM\EntityManager',
		),
	),
	
	'JcNavigation' => array(
		'profiler' => array(
			'collectors' => array(
				'jc_blog_pages_collector' => 'JcBlog\\Collector\\MenuCollector'
			)
		),
		'toolbar' => array(
			'entries' => array(
				'jc_blog_pages_collector' => 'jc-navigation/toolbar/jc-blog-pages'
			)
		)
	)
);

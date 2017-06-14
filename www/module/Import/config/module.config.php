<?php
return array(
    'controllers' => array(
        'invokables' => array(
            //'Import\Controller\Review' => 'Import\Controller\ReviewController',
        ),
        'factories' => array(
            'Import\Controller\Review' => 'Import\Factory\Controller\ReviewControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'import' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/import',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Import\Controller',
                        'controller'    => 'Review',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    /*
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    */
                    'review-upload' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/review/upload',
                            'defaults' => array(
                                'action' => 'upload'
                            )
                        )
                    ),
                    'review-import' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/review/import',
                            'defaults' => array(
                                'action' => 'import'
                            )
                        )
                    ),
                    'history' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/history',
                            'defaults' => array(
                                'action' => 'history'
                            )
                        )
                    ),
                    'history-details' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/history/details/:id',
                            'defaults' => array(
                                'action' => 'history-details'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    )
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Import' => __DIR__ . '/../view',
        ),
    ),
);

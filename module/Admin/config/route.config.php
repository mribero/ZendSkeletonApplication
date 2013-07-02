<?php

return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'admin-index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'entity' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/entity/:entity',
                            'defaults' => array(
                                'controller' => 'admin-entity',
                                'action' => 'index'
                            )
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'remove' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/remove',
                                    'defaults' => array(
                                        'controller' => 'admin-entity',
                                        'action' => 'remove'
                                    )
                                ),
                            ),
                            'create' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/create',
                                    'defaults' => array(
                                        'controller' => 'admin-entity',
                                        'action' => 'create'
                                    )
                                ),
                            ),
                            'edit' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/edit/:id',
                                    'defaults' => array(
                                        'controller' => 'admin-entity',
                                        'action' => 'edit'
                                    )
                                ),
                            )
                        )
                    )
                )
            ),
        ),
    )
);
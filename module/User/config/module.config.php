<?php

namespace User;

return array(
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => 'zfcuser_entity'
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
            // replace zfcUser templates
            'zfcuser' => __DIR__ . '/../view',
        ),
    ),
    'admin' => array(
        'entities' => array(
            'User' => array(
                'entity' => 'User\Entity\User',
                'fields' => array('id', 'username', 'email', 'display_name'),
                'allow' => array('list', 'edit', 'remove'),
                'filter' => array('username', 'email', 'display_name')
            )
        )
    )
);

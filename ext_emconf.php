<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'BE auto login',
    'description' => 'Makes automatic BE login possible.',
    'category' => 'services',
    'author' => 'Marc Wöhlken',
    'author_email' => 'marc.woehlken@hmmh.de',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

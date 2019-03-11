<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Register new authentication service
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'auth',
    \HMMH\BeAutoLogin\Service\AuthenticationService::class,
    array(
        'title' => 'User authentication',
        'description' => 'Auto authentication based .env file.',
        'subtype' => 'getUserBE,authUserBE',
        'available' => TRUE,
        'priority' => 80,
        'quality' => 80,
        'os' => '',
        'exec' => '',
        'className' => \HMMH\BeAutoLogin\Service\AuthenticationService::class
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysFetchUser'] = true;
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysAuthUser'] = true;

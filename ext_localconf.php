<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isDevelopment()) {
    $t3version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::getCurrentTypo3Version();
    $className = \HMMH\BeAutoLogin\Service\Version8\AuthenticationService::class;

    if (version_compare($t3version, '9.5', '>=')) {
        $className = \HMMH\BeAutoLogin\Service\Version9\AuthenticationService::class;
    }

    // Register new authentication service
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        $_EXTKEY,
        'auth',
        \HMMH\BeAutoLogin\Service\AuthenticationService::class,
        [
            'title' => 'User authentication',
            'description' => 'Auto authentication based .env file.',
            'subtype' => 'getUserBE,authUserBE',
            'available' => true,
            'priority' => 80,
            'quality' => 80,
            'os' => '',
            'exec' => '',
            'className' => $className,
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysFetchUser'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['BE_alwaysAuthUser'] = true;
}

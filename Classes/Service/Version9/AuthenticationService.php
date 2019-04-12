<?php

namespace HMMH\BeAutoLogin\Service\Version9;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class AuthenticationService
 *
 */
class AuthenticationService extends \HMMH\BeAutoLogin\Service\AuthenticationService
{
    /**
     * @param array $user
     *
     * @return int
     */
    public function authUser(array $user): int
    {
        return 200;
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    function getExtensionConfiguration(): array
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationUtility = $objectManager->get(ExtensionConfiguration::class);

        return $configurationUtility->get('be_autologin');
    }
}

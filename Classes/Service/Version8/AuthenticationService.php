<?php

namespace HMMH\BeAutoLogin\Service\Version8;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

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
    public function authUser(array $user)
    {
        return 200;
    }

    /**
     * @return array
     */
    function getExtensionConfiguration(): array
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationUtility = $objectManager->get(ConfigurationUtility::class);

        return $configurationUtility->getCurrentConfiguration('be_autologin');
    }
}

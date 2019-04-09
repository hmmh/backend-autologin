<?php

namespace HMMH\BeAutoLogin\Service\Version9;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Class AuthenticationService
 *
 */
class AuthenticationService extends \TYPO3\CMS\Sv\AuthenticationService
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
}

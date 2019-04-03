<?php

namespace HMMH\BeAutoLogin\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Class AuthenticationService
 *
 */
class AuthenticationService extends \TYPO3\CMS\Sv\AuthenticationService
{
    const COOKIE_NAME = 'TYPO3_AUTOLOGIN_USER';

    /**
     * @return bool
     */
    public function getUser()
    {
        $remoteAddress = GeneralUtility::getIndpEnv('REMOTE_ADDR');

        $extension = new ConfigurationUtility;
        $extension->getCurrentConfiguration('be_autologin');
        $whitelistAddresses = GeneralUtility::trimExplode(',', $extension['whilelistIpAdresses'], true);

        if (
            GeneralUtility::getApplicationContext()->isDevelopment()
            && ('cli' !== PHP_SAPI)
            && (0 < count($whitelistAddresses)
            && in_array($remoteAddress, $whitelistAddresses))
        ) {
            $autoLoginUserName = trim(
                GeneralUtility::_GET(static::COOKIE_NAME) ?? $_COOKIE[static::COOKIE_NAME] ?? getenv(static::COOKIE_NAME)
            );

            if ((empty($_COOKIE[static::COOKIE_NAME])) || ($_COOKIE[static::COOKIE_NAME] !== $autoLoginUserName)) {
                setcookie(static::COOKIE_NAME, $autoLoginUserName);
            }

            return $this->fetchUserRecord($autoLoginUserName);
        } else {
            return false;
        }
    }

    /**
     * @param array $user
     *
     * @return int
     */
    public function authUser(array $user)
    {
        return 200;
    }
}

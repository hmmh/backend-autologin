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
    protected function hasAllowedRemoteAddress()
    {
        $extension = new ConfigurationUtility;
        $extension->getCurrentConfiguration('be_autologin');

        $whitelistIpAddresses = GeneralUtility::trimExplode(',', $extension['whitelistIpAddresses'], true);
        $remoteAddress = GeneralUtility::getIndpEnv('REMOTE_ADDR');

        foreach ($whitelistIpAddresses as $whitelistIpAddress) {
            if (GeneralUtility::cmpIP($remoteAddress, $whitelistIpAddress)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getUser()
    {
        if (
            ('cli' !== PHP_SAPI)
            && GeneralUtility::getApplicationContext()->isDevelopment()
            && $this->hasAllowedRemoteAddress()
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

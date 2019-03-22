<?php

namespace HMMH\BeAutoLogin\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        if (GeneralUtility::getApplicationContext()->isDevelopment() && ('cli' !== PHP_SAPI)) {
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

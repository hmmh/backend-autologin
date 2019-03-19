<?php

namespace HMMH\BeAutoLogin\Service;

class AuthenticationService extends \TYPO3\CMS\Sv\AuthenticationService
{
    public function getUser()
    {
        if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isDevelopment() && ('cli' !== PHP_SAPI)) {
            $autoLoginUserName = trim(getenv('TYPO3_AUTOLOGIN_USER'));

            return $this->fetchUserRecord($autoLoginUserName);
        } else {
            return false;
        }
    }

    public function authUser(array $user)
    {
        return 200;
    }
}

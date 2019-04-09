<?php

namespace HMMH\BeAutoLogin\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Class AuthenticationService
 *
 */
abstract class AuthenticationService extends \TYPO3\CMS\Sv\AuthenticationService
{
    const COOKIE_NAME = 'TYPO3_AUTOLOGIN_USER';

    const YEAR_SECONDS = 60 /* seconds */ * 60 /* minutes */ * 24 /* hours */ * 30 /* days */ * 12 /* months */;

    /**
     * @return bool
     */
    protected function hasAllowedRemoteAddress()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $configurationUtility = $objectManager->get(ConfigurationUtility::class);
        $extension = $configurationUtility->getCurrentConfiguration('be_autologin');
        $whitelistIpAddresses = GeneralUtility::trimExplode(',', $extension['whitelistIpAddresses']['value'], true);

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
                setcookie(static::COOKIE_NAME, $autoLoginUserName, time() + static::YEAR_SECONDS);
            }

            return $this->fetchUserRecord($autoLoginUserName);
        } else {
            return false;
        }
    }
}

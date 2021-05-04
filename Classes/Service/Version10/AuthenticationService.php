<?php

namespace HMMH\BeAutoLogin\Service\Version10;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class AuthenticationService
 *
 */
class AuthenticationService extends \TYPO3\CMS\Core\Authentication\AuthenticationService
{
    const COOKIE_NAME = 'TYPO3_AUTOLOGIN_USER';

    const YEAR_SECONDS = 60 /* seconds */ * 60 /* minutes */ * 24 /* hours */ * 30 /* days */ * 12 /* months */;

    /**
     * @return bool
     */
    protected function hasAllowedRemoteAddress()
    {
        $extension = $this->getExtensionConfiguration();
        $whitelistIpAddresses = GeneralUtility::trimExplode(
            ',',
            $extension['whitelistIpAddresses']['value'] ?? $extension['whitelistIpAddresses'],
            true
        );

        $remoteAddress = GeneralUtility::getIndpEnv('REMOTE_ADDR');

        foreach ($whitelistIpAddresses as $whitelistIpAddress) {
            if (GeneralUtility::cmpIP($remoteAddress, $whitelistIpAddress)) {
                return true;
            }
        }

        return false;
    }

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
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var ExtensionConfiguration $configurationUtility */
        $configurationUtility = $objectManager->get(ExtensionConfiguration::class);

        return $configurationUtility->get('be_auto_login');
    }

    /**
     * @return bool
     */
    public function getUser()
    {
        if (
            ('cli' !== PHP_SAPI)
            && Environment::getContext()->isDevelopment()
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

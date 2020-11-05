# TYPO3 Backend Auto Login

This extension will allow you to login to the TYPO3 backend without providing username and password manually. This may
be quite usefull during development and may save a lot of time. 
 
## Installation

Installation can be done via the TYPO3 extension manager or by using composer. As auto login will only work in development mode
use `--dev` option for composer installation.

    composer require hmmh/be-auto-login --dev

## Configuration

### Access restrictions

For security reasons auto login will only be possible if your TYPO3 system is running in development application context,
see [TYPO3 API reference](https://docs.typo3.org/typo3cms/CoreApiReference/latest/ApiOverview/Bootstrapping/Index.html#application-context)
for a general explanation.

Additionally you can restrict auto login to a certain pool of IP addresses by modifying the the setting
`White list with ip addresses` in the extension configuration. An IP address pool can be specified by a comma separated
list of single IP addresses and IP ranges (defined by using "*" as wildcard character).
   
| value | description | 
|---|---|
| *                                       | Any IP address. This is the default value  |
| 192.168.0.123                           | One specific IP address |
| 192.168.0.123, 192.168.0.227            | Two specific IP addresses |
| 192.168.0.*                             | A range of IP addresses from 192.168.0.0 to 192.168.0.255 |
| 192.168.0.*, 192.168.1.22, 192.168.1.23 | Mixture of single IP addresses and IP ranges |
### How to auto login?

In order to use auto login you need the username of a valid TYPO3 backend user account. This username will
be used to login using one of the following methods. 

#### By .env file

If you always want to use the same user name for auto login you can simply define it in a `.env` file which
has to be stored in your document root or in a folder above it.

Example `.env` file:

    TYPO3_AUTOLOGIN_USER=example-user

#### By Cookie

If you need a bit more flexibility you can specify the user name by setting a cookie in your browser.
You can do this by using the developer tools of the browser of your choice by using the built in developer
console (often opened by pressing F12). Set the cookie name to `TYPO3_AUTOLOGIN_USER` and store the username as
cookie value.

#### By GET parameter

The user name can be specified via GET parameter. To choose a user name for auto login you simply open your
TYPO3 backend using ` http://127.0.0.1/typo3/?TYPO3_AUTOLOGIN_USER=admin` (substitute 127.0.0.1 with your domain name).

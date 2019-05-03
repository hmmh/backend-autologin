# TYPO3 Backend Auto Login

This extension will allow you to enter the TYPO3 backend without manual login. This may be quite usefull
during development. 
 
## Installation

Installation can be done via extension manager or by using composer:

    composer require hmmh/be-auto-login --dev

## Configuration

### Access restrictions

For security reasons auto login will only be possible if your system is running in dev context, see
https://docs.typo3.org/typo3cms/CoreApiReference/latest/ApiOverview/Bootstrapping/Index.html#application-context
for a general explanation.

Additionally you can restrict auto login to a certain range of IP addreses by modifying the the setting
`White list with ip addresses` in the extension configuration. IP ranges can be specified by a comma separated
list of ip addresses and ranges.

Examples:

    // Only one ip address
    192.168.0.123

    // Two ip addresses
    192.168.0.123, 192.168.0.227

    // A range of addresses from 192.168.0.0 to 192.168.0.255
    192.168.0.*
    
    // Mixture of single addresses and ranges
    192.168.0.*, 192.168.1.22, 192.168.1.23
    
  
### How to auto login?

There are several options available to define which user should be used for auto login.

#### By .env file

If you always want to use the same user name for auto login you can simply define it in an `.env` file which
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

## Develop with Extension

First:

    $ composer install
    $ cd .Build
    $ echo "TYPO3_CONTEXT=Development" > .env
    $ touch FIRST_INSTALL
    $ cd ..
    $ composer serve

Open: http://127.0.0.1/typo3/

- Default: Use MySQL for TYPO3 8.7 LTS
- Easy: Use Sqlite for TYPO3 9.5 LTS (you find your database under ./var/sqlite/)
- Admin: Create "admin" account w/ password

Then:

    $ cd .Build/typo3conf/ext
    $ ln -sfn ../../../ be_autologin
    $ cd ../../..
    $ vendor/bin/typo3cms extension:activate be_autologin

Open: http://127.0.0.1/typo3/?TYPO3_AUTOLOGIN_USER=admin

Your are logged in. 

Have fun!

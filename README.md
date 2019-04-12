Develop with Extension
----------------------

First:

    $ composer install
    
    $ cd .Build
    $ echo "TYPO3_CONTEXT=Development" > .env
    $ touch FIRST_INSTALL

Open: http://127.0.0.1/typo3/

- Default: Use MySQL for TYPO3 8.7 LTS
- Easy: Use Sqlite for TYPO3 9.5 LTS (you find you database under ./var/sqlite/)
- Admin: Create "admin" account


    $ cd .Build/typo3conf/ext
    $ ln -sfn ../../../ be_autologin

Login: http://127.0.0.1/typo3/

- Activate "be_autologin"
- Save Extension settings

Open: http://127.0.0.1/typo3/?TYPO3_AUTOLOGIN_USER=admin

Your are logged in. 

Have fun!

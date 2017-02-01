## Development

### Install dev dependencies
```text
$ composer install
$ npm install yarn -g
$ yarn
```

### Build PHAR
```text
$ composer install --no-dev

$ curl -LSs https://box-project.github.io/box2/installer.php | php
$ php -d phar.readonly=0 box.phar build -vv
```

#### Private and public keys
**(!!!)** You'll need openssl private key (`.travis/phar-private.pem`) to build phar. Public key (`uspec.phar.pubkey`) is also created during `box build` run and is used to verify self updates. Currently Travis CI is responsible for build generation and deployment. It uses encoded version of my private key (`.travis/phar-private.pem.enc`).
```text
$ openssl genrsa -des3 -out phar-private.pem 4096
$ cp phar-private.pem phar-private.pem.passphrase-protected

$ openssl rsa -in phar-private.pem -out phar-private-nopassphrase.pem
$ cp phar-private-nopassphrase.pem phar-private.pem

$ rm phar-private.pem.passphrase-protected phar-private-nopassphrase.pem

$ mv phar-private.pem .travis/
```
See [Secure PHAR Automation](https://mwop.net/blog/2015-12-14-secure-phar-automation.html) for detailed guide.

### Dev mode
Update / rollback functionality is available in phar context and dev mode only. It can be enabled in custom `.env` file: 

```text
$ cat .env

DEV_MODE=1
```

Alternatively env variable can be set globally: 

```text
$ export DEV_MODE=1 && bin/uspec list self --raw                                                                                                 1 ↵

self:update     Update uspec to the latest version
```

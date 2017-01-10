# SugarCRM upgrade spec generator
[![Latest Stable Version](https://poser.pugx.org/mikekamornikov/uspec/v/stable)](https://packagist.org/packages/mikekamornikov/uspec)
[![Build Status](https://travis-ci.org/mikekamornikov/UpgradeSpec.svg?branch=master)](https://travis-ci.org/mikekamornikov/UpgradeSpec)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/74152ef7-7e2d-4668-90a5-af33e40eddec/mini.png)](https://insight.sensiolabs.com/projects/74152ef7-7e2d-4668-90a5-af33e40eddec)
[![Code Climate](https://codeclimate.com/github/mikekamornikov/UpgradeSpec/badges/gpa.svg)](https://codeclimate.com/github/mikekamornikov/UpgradeSpec)
[![Dependency Status](https://www.versioneye.com/user/projects/586fd3e82f149b004e0b16c9/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/586fd3e82f149b004e0b16c9)

It's a CLI tool responsible for generation of simple step by step upgrade guide for SugarCRM instance.   

## Usage

- Download [the latest stable uspec executable](https://github.com/mikekamornikov/UpgradeSpec/releases) (you need both `phar` and `pubkey` files to be able to automatically update to the latest version later)
- `chmod +x uspec.phar`
- Run `uspec.phar` (`./uspec.phar`)

### Generate upgrade spec
```text
./uspec.phar generate:spec [options] [--] <path> [<version>]

Arguments:
  path                  Path to SugarCRM build we are going to upgrade
  version               Version to upgrade to

Options:
  -D, --dump            Save generated spec to file
```

### Update to the latest version
```text
./uspec.phar self:update [options]

Options:
  -s, --stability[=STABILITY]  Release stability (stable, unstable, any) [default: "any"]
```

### Rollback to previously used version
```text
./uspec.phar self:rollback
```

## Development

### Install dev dependencies
```text
composer install
npm install yarn -g
yarn
```

### Build PHAR
```text
# leave just required dependencies
composer install --no-dev

curl -LSs https://box-project.github.io/box2/installer.php | php
php -d phar.readonly=0 box.phar build -vv
```

#### Private and public keys
**(!!!)** You'll need openssl private key (`.travis/phar-private.pem`) to build phar. Public key (`uspec.phar.pubkey`) is also created during `box build` run and is used to verify self updates. Currently Travis CI is responsible for build generation and deployment. It uses encoded version of my private key (`.travis/phar-private.pem.enc`).
```text
# this one asks for password
openssl genrsa -des3 -out phar-private.pem 4096

cp phar-private.pem phar-private.pem.passphrase-protected

# get rid of password
openssl rsa -in phar-private.pem -out phar-private-nopassphrase.pem
cp phar-private-nopassphrase.pem phar-private.pem

# if you don't need copies
rm phar-private.pem.passphrase-protected phar-private-nopassphrase.pem

mv phar-private.pem .travis/
```
See [Secure PHAR Automation](https://mwop.net/blog/2015-12-14-secure-phar-automation.html) for detailed guide.

### Tests
We use [PHPSpec](http://www.phpspec.net/en/stable/) for spec BDD and unit tests. 
```text
yarn run test
```

## Troubleshooting
```text
TLS negotiation issues:
Download http://curl.haxx.se/ca/cacert.pem and set openssl.cafile=/path/to/cacert.pem in your php.ini file.

Alternatively you can run uspec like this:
php -d openssl.cafile=/path/to/cacert.pem /path/to/uspec.phar
```

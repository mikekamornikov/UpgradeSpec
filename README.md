# SugarCRM upgrade spec generator
[![Latest Stable Version](https://poser.pugx.org/mikekamornikov/uspec/v/stable)](https://packagist.org/packages/mikekamornikov/uspec)
[![Build Status](https://travis-ci.org/mikekamornikov/UpgradeSpec.svg?branch=master)](https://travis-ci.org/mikekamornikov/UpgradeSpec)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/74152ef7-7e2d-4668-90a5-af33e40eddec/mini.png)](https://insight.sensiolabs.com/projects/74152ef7-7e2d-4668-90a5-af33e40eddec)
[![Code Climate](https://codeclimate.com/github/mikekamornikov/UpgradeSpec/badges/gpa.svg)](https://codeclimate.com/github/mikekamornikov/UpgradeSpec)
[![Dependency Status](https://www.versioneye.com/user/projects/586fd3e82f149b004e0b16c9/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/586fd3e82f149b004e0b16c9)

It's a CLI tool responsible for generation of simple step by step upgrade guide for SugarCRM instance.   

## TLS negotiation issues
```text
Download http://curl.haxx.se/ca/cacert.pem and set openssl.cafile=/path/to/cacert.pem in your php.ini file.
```

## Usage
```text
./bin/uspec generate:spec [options] [--] <path> [<version>]

Arguments:
  path                  Path to SugarCRM build we are going to upgrade
  version               Version to upgrade to

Options:
  -D, --dump            Save generated spec to file
```

## Update to the latest version
```text
./bin/uspec self:update
```

## Rollback to previously used version
```text
./bin/uspec self:rollback
```

## Install dev dependencies
```text
composer install
npm install yarn -g
yarn
```

## Build PHAR
```text
curl -LSs https://box-project.github.io/box2/installer.php | php
php -d phar.readonly=0 box.phar build -vv
```

## Tests
```text
gulp test
```

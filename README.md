[![Build Status](https://travis-ci.org/mikekamornikov/UpgradeSpec.svg?branch=master)](https://travis-ci.org/mikekamornikov/UpgradeSpec)

# SugarCRM upgrade spec generator

## Install
```text
composer install
npm install yarn -g
yarn
```

## Usage
```text
./uspec generate:spec [options] [--] <path> [<version>]

Arguments:
  path                  Path to SugarCRM build we are going to upgrade
  version               Version to upgrade to

Options:
  -D, --dump            Save generated spec to file
```

## Update to the latest version
```text
./uspec self:update
```

## Rollback to previously used version
```text
./uspec self:rollback
```

## Tests
```text
gulp test
```

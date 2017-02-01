## Usage

- Download [the latest stable uspec executable](https://github.com/mikekamornikov/UpgradeSpec/releases) (you need both `phar` and `pubkey` files to be able to automatically update to the latest version later)
- `chmod +x uspec.phar`
- Run `uspec.phar`

### Generate upgrade spec
```text
$ uspec.phar generate:spec [options] [--] <path> [<version>]

Arguments:
  path                  Path to SugarCRM build we are going to upgrade
  version               Version to upgrade to

Options:
  -D, --dump            Save generated spec to file
```

### Self update / rollback
```text
$ uspec.phar self:update [options]

Options:
  -s, --stability[=STABILITY]  Release stability (stable, unstable, any) [default: "any"]
  -r, --rollback               Rollback uspec update
```

### As a docker container
```text
docker build -t uspec-app .
docker run --rm -ti -v /path/to/sugarcrm/build:/build uspec-app generate:spec /build 7.8
```

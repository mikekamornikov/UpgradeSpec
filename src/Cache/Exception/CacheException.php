<?php

namespace Sugarcrm\UpgradeSpec\Cache\Exception;

use Psr\SimpleCache\CacheException as PsrCacheException;

class CacheException extends \Exception implements PsrCacheException
{

}

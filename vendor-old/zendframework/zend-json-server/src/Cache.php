<?php
/**
 * @link      http://github.com/zendframework/zend-json-server for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Json\Server;

use Zend\Server\Cache as ServerCache;

/**
 * Cache server definition and SMD.
 */
class Cache extends ServerCache
{
    /**
     * Cache a service map description (SMD) to a file
     *
     * Returns true on success, false on failure
     *
     * @param  string $filename
     * @param  Server $server
     * @return bool
     */
    public static function saveSmd($filename, Server $server)
    {
        if (! is_string($filename)
            || (! file_exists($filename) && ! is_writable(dirname($filename)))
        ) {
            return false;
        }

        set_error_handler(function ($errno, $errstr) {
            // swallow errors; method returns false on failure
        }, E_WARNING);

        $test = file_put_contents($filename, $server->getServiceMap()->toJson());

        restore_error_handler();

        if (0 === $test) {
            return false;
        }

        return true;
    }

    /**
     * Retrieve a cached SMD
     *
     * On success, returns the cached SMD (a JSON string); a failure, returns
     * boolean false.
     *
     * @param  string $filename
     * @return string|false
     */
    public static function getSmd($filename)
    {
        if (! is_string($filename)
            || ! file_exists($filename)
            || ! is_readable($filename)
        ) {
            return false;
        }

        set_error_handler(function ($errno, $errstr) {
            // swallow errors; method returns false on failure
        }, E_WARNING);

        $smd = file_get_contents($filename);

        restore_error_handler();

        if (false === $smd) {
            return false;
        }

        return $smd;
    }

    /**
     * Delete a file containing a cached SMD
     *
     * @param  string $filename
     * @return bool
     */
    public static function deleteSmd($filename)
    {
        if (is_string($filename) && file_exists($filename)) {
            unlink($filename);
            return true;
        }

        return false;
    }
}

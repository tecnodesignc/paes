<?php

namespace Modules\Media\UrlResolvers;

use League\Flysystem\Adapter\Local;

class LocalUrlResolver
{
    /**
     * @param Local $adapter
     * @param string $path
     * @return string
     */
    public function resolve(Local $adapter, string $path): string
    {
        return asset($path);
    }
}

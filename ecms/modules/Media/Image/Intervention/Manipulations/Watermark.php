<?php

namespace Modules\Media\Image\Intervention\Manipulations;

use Intervention\Image\Image;
use Modules\Media\Image\ImageHandlerInterface;

class Watermark implements ImageHandlerInterface
{
    private array $defaults = [
        'source' => 'public/assets/watermark.png',
        'position' => 'bottom-right',
        'x' => null,
        'y' => null,
    ];

    /**
     * Handle the image manipulation request
     * @param Image $image
     * @param array $options
     * @return \Intervention\Image\Image
     */
    public function handle(Image $image, array $options): Image
    {
        $options = array_merge($this->defaults, $options);

        return $image->insert($options['source'], $options['position'], $options['x'], $options['y']);
    }
}

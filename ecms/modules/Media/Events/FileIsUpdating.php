<?php

namespace Modules\Media\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Media\Entities\File;

final class FileIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    /**
     * @var File
     */
    private File $file;

    public function __construct(File $file, array $attributes)
    {
        $this->file = $file;
        parent::__construct($attributes);
    }

}

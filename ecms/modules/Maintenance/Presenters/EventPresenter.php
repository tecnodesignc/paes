<?php

namespace Modules\Maintenance\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Maintenance\Entities\EventStatus;
use Modules\Maintenance\Entities\EventType;

class EventPresenter extends Presenter
{
    protected EventStatus $status;

    protected EventType $type;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->status = app('Modules\Maintenance\Entities\EventStatus');
        $this->type = app('Modules\Maintenance\Entities\EventType');
    }

    public function status(): string
    {
        return $this->status->get($this->entity->status);
    }

    public function status_class(): string
    {
        switch ($this->entity->status) {
            case EventStatus::PENDING:
                return 'info';
                break;
            case EventStatus::SCHEDULED:
                return 'blue';
                break;
            case EventStatus::DONE:
                return 'success';
                break;
            case EventStatus::EXPIRED:
                return 'warning';
                break;
            case EventStatus::CANCELED:
                return 'danger';
                break;
            default:
                return 'primary';
                break;
        }
    }

    public function type(): string
    {
        return $this->type->get($this->entity->status);
    }

    public function type_class(): string
    {
        switch ($this->entity->type) {
            case EventType::TASK:
                return 'purple';
                break;
            case EventType::REMINDER:
                return 'orange';
                break;
            case EventType::PREVENTIVEMAINTENANCE:
                return 'teal';
                break;
            case EventType::CORRECTIVEMAINTENANCE:
                return 'yellow';
                break;
            default:
                return 'primary';
                break;
        }
    }
}

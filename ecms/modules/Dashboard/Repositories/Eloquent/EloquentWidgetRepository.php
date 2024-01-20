<?php

namespace Modules\Dashboard\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Dashboard\Repositories\WidgetRepository;

class EloquentWidgetRepository extends EloquentBaseRepository implements WidgetRepository
{
    /**
     * Find the saved state of widgets for the given user id
     * @param int $userId
     * @return Model|Collection|Builder|array|null
     */
    public function findForUser(int $userId): Model|Collection|Builder|array|null
    {
        return $this->model->whereUserId($userId)->first();
    }

    /**
     * Update or create the given widgets for given user
     * @param array $widgets
     * @param int $userId
     * @return array|Builder|Collection|Model|null
     */
    public function updateOrCreateForUser(array $widgets, int $userId): Model|Collection|Builder|array|null
    {
        $widget = $this->findForUser($userId);

        if ($widget) {
            return $this->update($widget, ['widgets' => $widgets]);
        }

        return $this->create(['widgets' => $widgets, 'user_id' => $userId]);
    }
}

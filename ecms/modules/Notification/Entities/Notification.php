<?php

namespace Modules\Notification\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string type
 * @property string message
 * @property string icon_class
 * @property string title
 * @property string link
 * @property bool is_read
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property int user_id
 */
class Notification extends Model
{
    protected $table = 'notification__notifications';
    protected $fillable = ['user_id', 'type', 'message', 'icon_class', 'link', 'is_read', 'title'];
    protected $appends = ['time_ago'];
    protected $casts = ['is_read' => 'bool'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        $driver = config('encore.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    /**
     * Return the created time in difference for humans (2 min ago)
     * @return string
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function isRead() : bool
    {
        return $this->is_read === true;
    }
}

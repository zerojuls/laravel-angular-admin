<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    /**
     * Set attributes rules
     *
     * @var array
     */
    public $rules = [
        'phone' => 'max:11',
        'mobile_phone' => 'max:11',
    ];

    /**
     * Set default attributes values
     *
     * @var array
     */
    protected $attributes = [
        'state' => self::STATE_ACTIVE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', "deleted_at", "created_at", "updated_at"];

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}

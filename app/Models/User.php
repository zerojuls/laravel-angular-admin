<?php

namespace App\Models;

class User extends \App\User
{
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;

    /**
     * Set default attributes values
     *
     * @var array
     */
    protected $attributes = [
        'state' => self::STATE_ACTIVE,
    ];
}
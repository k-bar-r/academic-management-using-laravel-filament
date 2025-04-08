<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Classes;



class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get the classes associated with the subject.
     */
}

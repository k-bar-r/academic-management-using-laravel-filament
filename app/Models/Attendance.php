<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'status',
    ];
    /**
     * Relationships
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function Class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_name',
        'class_id',
        'subject_id',
        'exam_date',
        'duration',
        'description',
        'exam_type_code',
    ];

    // Define relationships if needed
    public function Class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_code', 'exam_type_code');
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
    public function examGroup()
    {
        return $this->hasMany(ExamMap::class);
    }

    // protected static function booted()
    // {
    //     static::created(function ($exam) {
    //         Student::where('class_id', $exam->class_id)->get()->each(function ($student) use ($exam) {
    //             Mark::create([
    //                 'student_id' => $student->id,
    //                 'exam_id' => $exam->id,
    //                 'mark' => 0  // Add this line to set default value
    //             ]);
    //         });
    //     });
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'status'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('enrollment_date', 'status', 'grade')
                    ->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getTotalFeesAttribute()
    {
        return $this->enrollments()
                    ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                    ->sum('courses.fee');
    }

    public function getTotalPaidAttribute()
    {
        return $this->transactions()
                    ->where('transaction_type', 'payment')
                    ->where('status', 'completed')
                    ->sum('amount');
    }
}
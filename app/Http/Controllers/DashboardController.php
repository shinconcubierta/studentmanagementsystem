<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::where('status', 'enrolled')->count();
        
        $totalRevenue = Transaction::where('transaction_type', 'payment')
                                 ->where('status', 'completed')
                                 ->sum('amount');
        
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        
        $recentEnrollments = Enrollment::with(['student', 'course'])
                                     ->latest()
                                     ->limit(5)
                                     ->get();
        
        $recentTransactions = Transaction::with('student')
                                       ->latest()
                                       ->limit(5)
                                       ->get();

        return view('dashboard', compact(
            'totalStudents',
            'activeStudents',
            'totalCourses',
            'activeCourses',
            'totalEnrollments',
            'activeEnrollments',
            'totalRevenue',
            'pendingTransactions',
            'recentEnrollments',
            'recentTransactions'
        ));
    }
}
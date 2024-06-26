<?php

namespace App\Http\Controllers;

use App\Models\Classs;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Jetstream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('admin.user', compact('user'));
    }

    public function class()
    {
        // Your logic for managing classes
    }

    public function teacher()
    {
        $user = Teacher::get();
        return view('admin.teacher', compact('user'));
    }

    public function teacherget()
    {
        return view('admin.addteacher');
    }

    public function teacheradd(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'string', 'min:8'], // Manually define password rules
            'role' => ['required', 'string'],
            'phone' => ['required', 'string', 'digits:10'], 
        ])->validate();
    
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        // Check the role and create the corresponding record
        if ($request->role == '1') {

          // dd("$user");
            Teacher::create([
                'user_id' => $user->id, 
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $request->phone,
              
            ]);
        } elseif ($request->role == '2') {
            Guardian::create([
                // Add guardian specific fields
            ]);
        } elseif ($request->role == '3') {
            Student::create([
                // Add student specific fields
            ]);
        }
    
        return redirect('/adminteacher')->with('success', 'Added Successfully');
    }
    public function teacherassign(Request $request, $id)
{   
    $subject = Subject::findOrFail($id);

    $request->validate([
        'teacher_id' => 'required|exists:users,id',
    ]);

    $subject->teacher_id = $request->input('teacher_id');
    $subject->save();

    return redirect()->back();
}

public function student()
{   
    $guardian =Guardian::get();
    $class =Classs::get();
    $user = Student::get();
    // dd($user);
    return view('admin.student', compact('user','guardian','class'));
}

public function adminadmission()
{
    $guardian =Guardian::get();
    $class =Classs::get();
    $students = Student::where('status', 'No')->get();
    return view('admin.admission', compact('students','guardian','class'));
}
public function approve($id)
{
    $student = DB::table('students')->where('user_id','=',$id)->update(['status'=>'Yes']);

    return redirect('/adminadmission')->with('success', 'Approved Successfully');
     
}


}

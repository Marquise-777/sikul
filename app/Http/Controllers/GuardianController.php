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



class GuardianController extends Controller
{
    public function index()
    {    
         $user = user::get();
         return view('guardian.student', compact('user'));
    }  

    public function admit()
    {    
         $user = user::get();
         $classs = classs::get();
         return view('guardian.admit', compact('user','classs'));
    }  

    public function submitform(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'last_marksheet' => 'required|file|mimes:pdf,jpeg,png|max:10240', 
            'class' => 'required|exists:classses,id', 
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => '3',
        ]);
        Student::create([
            'id' => $user->id, 
            'name' => $user->name,
            'email' => $user->email,
            'dob' => $request->date_of_birth,
            'gender' => $request->gender,
            'class' => $request->class,
            'marksheet' => $request->file('last_marksheet')->store('last_marksheets'), 
            'address' => $request->address,
            'phone number'=>$request->phone,
            'class_id'=>$request->class,
            'guardian_id'=>$request->guardian_id,
          
        ]);

       
        return redirect()->back()->with('success', 'Admission form submitted successfully!');
    }
    
    
}

<?php

namespace App\Http\Controllers\parent;

use App\Http\Controllers\Controller;
use App\Models\Parint;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function welcome()
    {
        $User_Id = Auth::user();
        $Parent = Parint::where('user_id',$User_Id->id)->first();
        // dd($Parent->id);
        $students = Student::where('parint_id',$Parent->id )->get();
        // dd($students);
        return view('parent.dashboard',compact('students'));
    }
}

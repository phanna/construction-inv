<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Tbl_staffs;
use App\Tbl_department;


class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('general.staff');
    }
    public function newstaffForm(){
        return view('vendor.newStaff');
    }
    public function getstafflId($id){
        $staffbyid = Tbl_staffs::staffId($id);
        return view('vendor.newStaff')->with('getSelectEdit',$staffbyid);
    }
    public function submitNewReceiver(){
        $fullName = request('fullName');
        $mobile = request('mobile');
        $gender = request('gender');
        $position = request('position');
        $type = request('type');
        $group = request('group');
        $staff_id = request('staff_id');

        if($staff_id){
            Tbl_staffs::where('id',$staff_id)->update([
                'staff_name'=>$fullName,
                'phone_number'=>$mobile,
                'gender'=>$gender,
                'position'=>$position,
                'type'=>$type,
                'staff_group'=>$group
            ]);
        }else{
            Tbl_staffs::create([
                'staff_name'=>$fullName,
                'phone_number'=>$mobile,
                'gender'=>$gender,
                'position'=>$position,
                'type'=>$type,
                'staff_group'=>$group
            ]);
        }

    }
    public function distoyReceiver(){
        $staffid = request('sup_id');
        $delete = Tbl_staffs::where('id',$staffid)->delete();
        if($delete)
            echo 'yes';
        else
            echo 'no';
    }

}

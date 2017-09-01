<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TblTaxRate;
use App\tbl_tax_component;
use App\Tbl_department;
use App\ItemCategory;
use App\User;
use App\Tbl_Role;
use App\Tbl_zones;
use App\Tbl_zones_detail;

use App\Http\Requests;
use Auth;
use Input;
use Hash;

class GeneralSittiing extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('general.general');
    }
    //manage department
    public function department(){
        $getDept = Tbl_department::get();
        return view('general.department')->with('getDept',$getDept);
    }

    public function addDepartment(){
        return view('vendor.newDepartment');
    }

    public function creatDeptForm()
    {
        //
        $dept_id=request('dept_id');
        if($dept_id){
            Tbl_department::where('id', $dept_id)->update([  
                'department_name'=>request('department')
            ]);
        }else{
            Tbl_department::create([
                'department_name'=>request('department')
            ]);
        }
    }

    public function editDept($id)
    {
        $selectEditDept = Tbl_department::where('id',$id)->get();
        return view('vendor.newDepartment')->with('selectEditDept',$selectEditDept);
    }

    public function deleteDept(){
        $id = request('dept_id');
        $delete = Tbl_department::where('id', $id)->delete();
        if($delete==1){
            return 'yes';
        }else{
            return 'no';
        }
    }
    // end manage department

    //manage category item
    public function categoryItem()
    {
        $getCate = ItemCategory::orderBy('id','desc')->get();
        return view('general.categoryItem')->with('getCate',$getCate);
    }
    public function addCategory()
    {
        return view('vendor.newCategory');
    }
    public function createCateForm()
    {
        $cate_id=request('cate_id');
        if($cate_id){
            ItemCategory::where('id', $cate_id)->update(['category_name'=>request('category')]);
        }else{
            ItemCategory::create(['category_name'=>request('category')]);
        }
    }
    public function editCate($id)
    {
        $selectEditCate = ItemCategory::where('id',$id)->get();
        return view('vendor.newCategory')->with('selectEditCate',$selectEditCate);
    }
    public function deleteCate(){
        $id = request('cate_id');
        $delete = ItemCategory::where('id', $id)->delete();
        if($delete==1){
            return 'yes';
        }else{
            return 'no';
        }
    }
    //end manage category item

    //manage user
    public function registerUser()
    {
        $getUser = User::get();
        return view('general.users')->with('getUsers',$getUser);
    }
    public function addUser()
    {
        $role = Tbl_Role::get();
        $getDept = Tbl_department::get();
        return view('vendor.newUsers')->with(array(
                                        'role'=>$role,
                                        'department'=>$getDept
                                    ));
    }
    public function createNewUser()
    {
        $userID = request('userID');
        if($userID){
            User::where('id',$userID)->update([
                'name' => request('name'),
                'email' => request('email'),
                'role_id' => request('role'),
                'dept_id'=>request('dept_id'),
                'position'=>request('position'),
                'telephone'=>request('telephone')
            ]);
        }else{
            User::create([
                'name' => request('name'),
                'role_id' => request('role'),
                'dept_id'=>request('dept_id'),
                'email' => request('email'),
                'position'=>request('position'),
                'telephone'=>request('telephone'),
                'password' => bcrypt(request('password'))
            ]);
        }
        return redirect('/newUser');
    }
     public function editUser($id)
    {
        $role = Tbl_Role::get();
        $getDept = Tbl_department::get();
        $selectEditUser = User::where('id',$id)->get();
        return view('vendor.newUsers')->with(array(
                                            'selectEditUser'=>$selectEditUser,
                                            'department'=>$getDept,
                                            'role'=>$role));
    }
    public function checkEmailExist(){
        $email = request('checkEmail');
        $userID = request('userid');

        if(!empty($userID)){
            $queries =User::where(array('email'=>$email,'id'=>$userID))->count();
            if ($queries > 0){
                echo 'true';
            }else{
                $queries2 =User::where('email',$email)->count();
                if ($queries2 > 0){
                    echo 'false';
                }else{
                    echo 'true';
                }
            }
        }else{
            $queries2 =User::where('email',$email)->count();
            if ($queries2 > 0){
                echo 'false';
            }else{
                echo 'true';
            }
        }
    }

    public function deleteUser(){
        $userID = request('user_id');
        $query = User::where('id',$userID)->delete();
        if($query){
            return 'yes';
        }else{
            return "no";
        }
    }

    public function changePassword(){
        $userID = Auth::user()->id;
        $selectEditUser = User::where('id',$userID)->get();
        return view('vendor.changePassword')->with('selectEditUser',$selectEditUser);
    }
    public function updatePassword(){
        $userID = Auth::user()->id;
        $oldPass = request('oldpassword');
        $userpass = Auth::user()->password;
        $newpass = bcrypt(request('newpassword'));
        $username = request('username');

        if (Hash::check($oldPass, $userpass))
        {
            $updatPass = User::where('id',$userID)
                ->update([
                    'password' => $newpass,
                    'name' => $username
                ]);
            if($updatPass){
                echo "yes";
            }else{
                echo "no";
            }
        }else{
            echo "nono";
        }  

    }
	public function permission(){
     
        return view('general.permission');
    }
	public function onChangeUser(){
     	$userID=request('userID');
		$query=User::where('id',$userID)->get();
		$data=array('userData'=>$query,'userid'=>$userID);
        return view('general.permission')->with($data);
    }
	public function onChangeUser2($userID){
     	//$userID=request('userID');
		$query=User::where('id',$userID)->get();
		$data=array('userData'=>$query,'userid'=>$userID);
        return view('general.permission')->with($data);
    }
	public function insertPermission(){
     	$userID=request('userid');
		$inputPermission=request('menuid');
		
		$permission='';
		foreach($inputPermission as $v){
			$permission.=$v.',';
		}
		$insert=User::where('id',$userID)->update([
                'permission' =>$permission 
            ]);
		//print_r($inputPermission);
		//exit();
		$query=User::where('id',$userID)->get();
		return redirect('/onChangeUser/'.$userID);
       // return view('general.permission')->with('userData',$query);
    }
	
	//manage zone location
    public function zone()
    {
        return view('general.zone');
    }
    public function createZoneForm()
    {
        $zone_id=request('zoneID');
        if($zone_id){
            Tbl_zones::where('id', $zone_id)->update(['zone'=>request('zonename')]);
        }else{
            Tbl_zones::create(['zone'=>request('zonename')]);
        }
    }
    public function EditZone($id)
    {
        $query = Tbl_zones::where('id',$id)->get();
        return json_encode($query);
    }
    public function deleteZone(){
        $id = request('zone_id');
        $delete = Tbl_zones::where('id', $id)->delete();
        if($delete){
            return 'yes';
        }else{
            return 'no';
        }
    }
    
    public function itemtozone(){
        return view('general.itemzone');
    }
    public function addItemTozone(){
        $zone_id = request('zone_id');
        $item_id = request('item_id');
        $qty = request('qty');
        $zoneID = request('zoneID');
        $data = [
            'zone_id'=>$zone_id,
            'item_id'=>$item_id,
            'qty'=>$qty
        ];
        echo $zoneID;
        if($zoneID){
            Tbl_zones_detail::updateZoneItem($zoneID,$data);
        }else{
            Tbl_zones_detail::createZoneItem($data);
        }

    }
    public function EditItemZone($id)
    {
        $query = Tbl_zones_detail::where('id',$id)->get();
        return json_encode($query);
    }
    public function deleteItemZone(){
        $id = request('zone_id');
        $delete = Tbl_zones_detail::where('id', $id)->delete();
    }

}

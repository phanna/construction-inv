<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Tbl_suppliers;
use App\Tbl_itemUnit;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**=============================================
     * Manage supplier form
     *==============================================
    */
    public function index()
    {
        return view('general.supplier');
    }
    public function create()
    {
        //
        $getsup_id = request('sup_id');
        if($getsup_id){
            Tbl_suppliers::where('id',$getsup_id)
            ->update([
                'company_name'=>request('company'),
                'seller'=>request('seller'),
                'phone'=>request('tel'),
                'address'=>request('address')
            ]);
        }else{
            Tbl_suppliers::create([
                'company_name'=>request('company'),
                'seller'=>request('seller'),
                'phone'=>request('tel'),
                'address'=>request('address')
            ]);
        }
    }
    public function showForm()
    {
        return view('vendor.newSupplier');
    }
    public function getSupplierid($id){
        $getSuppId = Tbl_suppliers::where('id',$id)->get();
        return view('vendor.newSupplier')->with('getSuppId',$getSuppId);
    }
    public function deleteSupplier()
    {
        //
        $supID = request('sup_id');
        $query = Tbl_suppliers::where('id',$supID)->delete();
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }



    /**=============================================
     * Manage Receiver form
     *==============================================
    */
    public function indexItemUnit()
    {
        //
        $unit = Tbl_itemUnit::get();
        return view('general.itemUnit')->with('unit',$unit);
    }
    public function createItemUnit()
    {
        //
        /*$getsup_id = request('sup_id');
        if($getsup_id){
            Tbl_itemUnit::where('id',$getsup_id)
            ->update([
                'company_name'=>request('company'),
                'seller'=>request('seller'),
                'phone'=>request('tel'),
                'address'=>request('address')
            ]);
        }else{*/
            Tbl_itemUnit::create([
                'name'=>request('unitname')
            ]);
        // }
    }
    public function showFormItemUnit()
    {
        return view('vendor.newSupplier');
    }
    public function getItemUnitid($id){
        $getSuppId = Tbl_itemUnit::where('id',$id)->get();
        return view('vendor.newSupplier')->with('getSuppId',$getSuppId);
    }
    public function deleteItemUnit()
    {
        //
        $supID = request('sup_id');
        $query = Tbl_itemUnit::where('id',$supID)->delete();
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }

}

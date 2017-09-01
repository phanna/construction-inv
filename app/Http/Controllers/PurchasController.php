<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use App\Tbl_PurchaseDetail;
use App\Tbl_purchase;
use App\Tbl_suppliers;
use App\Tbl_item;
use App\User;
use Auth;
use Carbon;



class PurchasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index(){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)->where('is_actived',0)->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',1)->orwhere('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::where('status','!=',3)->get()->count();

    	$purchase = Tbl_purchase::PurchaseStatusNot3();
    	return view('purchasing/purchasing')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase));
    }
    public function listPurchaseByStatuse($status){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)->where('is_actived',0)->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',1)->orwhere('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::where('status','!=',3)->get()->count();

        if($status==2){
            $purchase =Tbl_purchase::PurchaseStatusNot3();
        }elseif($status==1){
             $purchase =Tbl_purchase::PurchaseStatus1or2();
        }else{
            $purchase = Tbl_purchase::PurchaseStatus0();
        }
        return view('purchasing/purchasing')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase,'status'=>$status));
    }
    public function addNewItemPurchase(){
    	return view('purchasing/addNewItemPurchase');
    }
    public function storeItemPurchase($item_id){
		$getItem = Tbl_item::where('id',$item_id)->get();
		$arrayItem = array();
        foreach($getItem as $item){
            $arrayItem['name']=$item->item_name;
            $arrayItem['code']=$item->item_code;
            $arrayItem['measure']=$item->item_measure;
        }
        echo json_encode($arrayItem);
    }

    public function viewPurchaseDetail($id)
    {
        $queriesItem = Tbl_purchase::listPurchaseItem($id);
        return view('purchasing.viewPurchaseDetail')->with("getSaleDetails",$queriesItem);
    }

    public function editPurchaseDetail($id)
    {  
        $getPurDetail = Tbl_purchase::listPurchasDetail($id);
        return view('purchasing.addNewItemPurchase')->with(array('purchaseID'=>$id,'getPurDetail'=>$getPurDetail));
    }

    public function addItemToPurchasing(){
        $userid = Auth::user()->id;
        $item_id=request('itemId');
        $item_qty=request('amount');
        $purchaseid = request('purchaseid');
        $supplier = request('supplier');
        $unit_price = request('price');
        $staff_id = request('staffname');
        $noted = request('note');
        $zoneID = request('zoneID');

        $datePurchase = Carbon\Carbon::parse(request('datePurchase'));
        $invDate = Carbon\Carbon::now()->format('Ymd');

        $getInv=Tbl_purchase::whereYear('created_at', '=', date('Y'))
                        ->whereMonth('created_at', '=', date('n'))->get();

        $getCountInv=$getInv->count()+1;

        if($getCountInv>=100){
            $newInv=$getCountInv;
        }else if($getCountInv>=10){
            $newInv='0'.$getCountInv;
        }else if($getCountInv<10 && $getCountInv>0){
            $newInv='00'.$getCountInv;
        }else{
            $newInv='001';
        }
        $purchaseCode = 'Pur-'.$invDate.$newInv;

		if($purchaseid){
			$deletePurchaseDetail = Tbl_PurchaseDetail::where('purchase_id',$purchaseid)->delete();
			foreach ($item_id as $key => $value) {
				Tbl_PurchaseDetail::create([
					'purchase_id'=>$purchaseid,
					'item_id'=>$value,
					'qty'=>$item_qty[$key],
					'unit_price'=>$unit_price[$key]
				]);
			}
            $insertInv=Tbl_purchase::where('id',$purchaseid)->update([
                'user_id'=>$userid,
                'supl_id'=>$supplier,
                'staff_id'=>$staff_id,
                'purchase_date'=>$datePurchase,
                'zone_id'=>$zoneID,
                'note'=>$noted
            ]);
		}else{	
			$insertInv=Tbl_purchase::create([
				'user_id'=>$userid,
		    	'supl_id'=>$supplier,
		    	'staff_id'=>$staff_id,
		    	'purchase_code'=>$purchaseCode,
		    	'status'=>0,
		    	'purchase_date'=>$datePurchase,
                'note'=>$noted,
                'zone_id'=>$zoneID
			]);
			$saved = $insertInv->save();

			if($saved){
                foreach ($item_id as $key => $value) {
    				Tbl_PurchaseDetail::create([
    					'purchase_id'=>$insertInv->id,
    					'item_id'=>$value,
    					'qty'=>$item_qty[$key],
    					'unit_price'=>$unit_price[$key]
    				]);
                }
			}
		}
	}
    public function managePurchase(){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)->where('is_actived',0)->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',1)->orwhere('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::get()->count();

        $purchase = Tbl_purchase::PurchaseStatus();
        return view('purchasing.purchaseManagement')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase));
    }
    public function listPurchaseManagement($status){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)->where('is_actived',0)->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',1)->orwhere('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::get()->count();

        if($status==2){
            $purchase = Tbl_purchase::PurchaseStatus();
        }elseif($status==1){
            $purchase=Tbl_purchase::PurchaseStatus1or2();
        }else{
            $purchase=Tbl_purchase::PurchaseStatusall($status);
        }
        
        return view('purchasing.purchaseManagement')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase,'status'=>$status));
    }
    public function approvePurchase($id){
        $query = Tbl_purchase::where('id',$id)->update(['status'=>1]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }
    public function rejectPurchase($id){
        $query = Tbl_purchase::where('id',$id)->update(['is_actived'=>1]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }
    public function purchase_managerapprove(){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)
                                        ->where('is_actived',0)
                                        ->orwhere('status',1)
                                        ->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::get()->count();

        $purchase = Tbl_purchase::PurchaseStatus();
        return view('purchasing.purchaseApproveManager')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase));
    }
    public function listpurchase_managerapprove($status){
        $countPurchase=array();
        $countPurchase[0]=Tbl_purchase::where('status',0)
                                        ->where('is_actived',0)
                                        ->orwhere('status',1)
                                        ->get()->count();
        $countPurchase[1]=Tbl_purchase::where('status',2)->get()->count();
        $countPurchase[2]=Tbl_purchase::get()->count();

        if($status==2){
            $purchase = Tbl_purchase::PurchaseStatus();
        }elseif($status==1){
            $purchase=Tbl_purchase::PurchaseStatus2();
        }else{
            $purchase=Tbl_purchase::PurchaseStatus0or1();
        }
        
        return view('purchasing.purchaseApproveManager')->with(array('purchases'=>$purchase,'countPurchase'=>$countPurchase,'status'=>$status));
    }
    public function manageApprovePurchase($id){
        $query = Tbl_purchase::where('id',$id)->update(['status'=>2]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }
}

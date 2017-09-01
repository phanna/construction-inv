<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tbl_Item_Stock;
use App\tbl_sale_invs;
use App\tbl_sale_details;
use App\Tbl_item;
use App\Tbl_PurchaseDetail;
use App\Tbl_purchase;
use App\Tbl_suppliers;

use Carbon;


class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function warehouse(){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',2)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',3)->get()->count();
        $countRequest[2]=tbl_sale_invs::where('status',2)->orwhere('status',3)->get()->count();
        $getSaleInv = tbl_sale_invs::orderBy('id','desc')->where('status',2)->orwhere('status',3)->get();

        return view('warehouse.warehouse')->with(array('getSaleInv'=>$getSaleInv,'countRequest'=>$countRequest));
    }

    public function listWareHouseManagement($status){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',2)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',3)->get()->count();
        $countRequest[2]=tbl_sale_invs::where('status',2)->orwhere('status',3)->get()->count();
		
        if($status==2){
            $getSaleInv = tbl_sale_invs::orderBy('id','desc')->where('status',2)->orwhere('status',3)->get();
        }else if($status==0){
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',2)->get();
        }else if($status==1){
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',3)->get();
        }
        return view('warehouse.warehouse')->with(array(
                                                    'getSaleInv'=>$getSaleInv,
                                                    'countRequest'=>$countRequest,
                                                    'status'=>$status));
    }

    public function listStock($id){
       $queriesItem = DB::table('tbl_items')
            ->select('tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_saleinv_details.*')
            ->join('tbl_saleinv_details', 'tbl_saleinv_details.item_id', '=', 'tbl_items.id')
            ->orderBy('tbl_saleinv_details.id','desc')
            ->where('tbl_saleinv_details.sale_inv_id',$id)->get();
        return view('warehouse.viewDetailTakeout')->with("getSaleDetails",$queriesItem);
    }
    public function listStockview($view,$id){
        $queriesItem = DB::table('tbl_items')
            ->select('tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_saleinv_details.*')
            ->join('tbl_saleinv_details', 'tbl_saleinv_details.item_id', '=', 'tbl_items.id')
            ->orderBy('tbl_saleinv_details.id','desc')
            ->where('tbl_saleinv_details.sale_inv_id',$id)->get();
        return view('warehouse.viewDetailTakeout')->with(array(
                                                    "getSaleDetails"=>$queriesItem,
                                                    'views'=>$view));
    }
    public function addStockOut(){
    	$itemid = request('itemid');
    	$qty = request('qty');
    	$saleid = request('saleInvid');
        $unit_price = request('price');
        $total = request('totalprice');
        $staff_id = request('staff_id');
        $date = Carbon\Carbon::parse(request('dateDelever'));

    	foreach($itemid as $itemkey=>$itemValue){
    		$query = Tbl_Item_Stock::create([
	    		'item_id'=>$itemValue,
				'amount'=>$qty[$itemkey],
				'inv_sale_id'=>$saleid[$itemkey],
                'unit_price'=>$unit_price[$itemkey],
                'purchase_date'=>$date,
				'status'=>1
	    	]);
	    	tbl_sale_invs::where('id',$saleid[$itemkey])->update([
				'status'=>3,
                'total_price'=>$total,
                'date_out'=>$date,
                'takeout_staff_id'=>$staff_id
	    	]);
    	}
    }
    //manage take in stock
    public function stockin(){
        $countRequest=array();
        $countRequest[0]=Tbl_purchase::where('status',2)->get()->count();
        $countRequest[1]=Tbl_purchase::where('status',3)->get()->count();
        $countRequest[2]=Tbl_purchase::where('status',2)->orwhere('status',3)->get()->count();
        $purchases = Tbl_purchase::PurchaseStatus2or3();

        return view('stockin.takeinhouse')->with(array('purchases'=>$purchases,'countRequest'=>$countRequest));
    }
    public function listStockinstatus($status){
        $countRequest=array();
        $countRequest[0]=Tbl_purchase::where('status',2)->get()->count();
        $countRequest[1]=Tbl_purchase::where('status',3)->get()->count();
        $countRequest[2]=Tbl_purchase::where('status',2)->orwhere('status',3)->get()->count();
        
        if($status==2){
            $purchases = Tbl_purchase::PurchaseStatus2or3();
        }else if($status==0){
            $purchases=Tbl_purchase::PurchaseStatus2();
        }else if($status==1){
            $purchases=Tbl_purchase::PurchaseStatus3();
        }
        return view('stockin.takeinhouse')->with(array(
                                                    'purchases'=>$purchases,
                                                    'countRequest'=>$countRequest,
                                                    'status'=>$status));
    }
    public function listStocktakeIn($id){
       $queriesItem = Tbl_purchase::listPurchaseItem($id);
        return view('stockin.viewDetailTakein')->with("getPurDetails",$queriesItem);
    }
    public function listStockviewtakeIn($view,$id){
        $queriesItem = Tbl_purchase::listPurchaseItem($id);
        return view('stockin.viewDetailTakein')->with(array(
                                                    "getPurDetails"=>$queriesItem,
                                                    'views'=>$view));
    }

    public function submitStockIn(){
        $itemid = request('itemid');
        $qty = request('qty');
        $saleid = request('saleInvid');
        $unit_price = request('price');
        $total = request('totalprice');
        $purchaseNote = request('purchasenoted');
        $date = Carbon\Carbon::parse(request('dateDelever'));
       // echo 'Hello date '.$date;
        foreach($itemid as $itemkey=>$itemValue){
            $query = Tbl_Item_Stock::create([
                'item_id'=>$itemValue,
                'amount'=>$qty[$itemkey],
                'inv_purchase_id'=>$saleid[$itemkey],
                'purchase_date'=>$date,
                'unit_price'=>$unit_price[$itemkey],
                'status'=>0
            ]);
            Tbl_purchase::where('id',$saleid[$itemkey])->update([
                'status'=>3,
                'total_price'=>$total,
                'date_in'=>$date,
                'purchase_note'=>$purchaseNote
            ]);
        }
    }
}

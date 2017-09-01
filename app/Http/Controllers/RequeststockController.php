<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\tbl_sale_invs;
use App\Tbl_Item_Stock;
use App\Tbl_item;
use App\tbl_sale_details;

use Auth;
use Carbon;

class RequeststockController extends Controller
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
        //
        $userid = Auth::user()->id;
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',0)->get()->count();
        $countRequest[1]=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',1)->orwhere('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::orderBy('id','desc')
                                        ->where('user_id',$userid)
                                        ->where('status','!=',3)->get()->count();
        $getSaleInv = tbl_sale_invs::orderBy('id','desc')
                                        ->where('user_id',$userid)
                                        ->where('status','!=',3)->get();

        return view('stockRequest.stockRequest')->with(array(
                                                'getSaleInv'=>$getSaleInv,
                                                'countRequest'=>$countRequest
                                                ));
    }
    //list request follow by statust
    public function listRequest($status)
    {
        $userid = Auth::user()->id;
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',0)->get()->count();
        $countRequest[1]=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',1)->orwhere('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status','!=',3)->get()->count();
        if($status==2){
            $getSaleInv = tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)->where('status','!=',3)->get();
        }elseif($status==1){
            $getSaleInv = tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',1)->orwhere('status',2)->get();
        }else{
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('user_id',$userid)
                                        ->where('status',$status)->get();
        }
        return view('stockRequest.stockRequest')->with(array('getSaleInv'=>$getSaleInv,'countRequest'=>$countRequest,'status'=>$status));
    }
    public function addNewItemRequest()
    {
        return view('stockRequest.addNewItemRequest');
    }
    public function getSaleDetailview($id)
    {
        $queriesItem = DB::table('tbl_items')
            ->select('tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_saleinv_details.*')
            ->join('tbl_saleinv_details', 'tbl_saleinv_details.item_id', '=', 'tbl_items.id')
            ->where('tbl_saleinv_details.sale_inv_id',$id)->get();

        return view('stockRequest.viewStockDetail')->with("getSaleDetails",$queriesItem);
    }
    public function editSaleDetail($id)
    {  
        $getSaleDetail = DB::table('tbl_items')
                ->select('tbl_sale_invs.toDate','tbl_sale_invs.staff_id','tbl_sale_invs.note','tbl_items.id','tbl_sale_invs.zone_id','tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_saleinv_details.sale_inv_id','tbl_saleinv_details.unit_price','tbl_saleinv_details.item_id','tbl_saleinv_details.qty')
                ->join('tbl_saleinv_details', 'tbl_saleinv_details.item_id', '=', 'tbl_items.id')
                ->join('tbl_sale_invs','tbl_saleinv_details.sale_inv_id','=','tbl_sale_invs.id')
                ->where('tbl_saleinv_details.sale_inv_id',$id)->get();

        return view('stockRequest.addNewItemRequest')->with(array('itemID'=>$id,'getSaleDetail'=>$getSaleDetail));
    }
    public function selectItemName($item_id){
		$getItem = DB::table('tbl_items')
                ->select('tbl_item_stocks.unit_price','tbl_items.*')
                ->join('tbl_item_stocks','tbl_item_stocks.item_id', '=', 'tbl_items.id')
                ->where('tbl_item_stocks.item_id',$item_id)->get();

		$arrayItem = array();
        foreach($getItem as $item){
            $arrayItem['name']=$item->item_name;
            $arrayItem['code']=$item->item_code;
            $arrayItem['price']=$item->unit_price;
			$arrayItem['measure']=$item->item_measure;
        }
        echo json_encode($arrayItem);
    }
    public function addItemToInvoid(){
        $userid = Auth::user()->id;
        $item_id=request('itemId');
        $item_qty=request('amount');
        $invID = request('invID');
        $dateRequest = Carbon\Carbon::parse(request('toDate'));
        $unit_price = request('price');
        $invDate = Carbon\Carbon::now()->format('Ymd');
        $staff_id = request('staffname');
        $noted = request('note');
        $zoneID = request('zoneID');

        $getInv=tbl_sale_invs::whereYear('created_at', '=', date('Y'))
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
        $invoidCode = 'Inv-'.$invDate.$newInv;

		if($invID){
			$deleteSaleDetail = tbl_sale_details::where('sale_inv_id',$invID)->delete();
			
			foreach ($item_id as $key => $value) {
    				tbl_sale_details::create([
    					'sale_inv_id'=>$invID,
    					'item_id'=>$value,
                        'unit_price'=>$unit_price[$key],
    					'qty'=>$item_qty[$key]
    				]);
                }
            $insertInv=tbl_sale_invs::where('id',$invID)->update([
                'toDate'=>$dateRequest,
                'staff_id'=>$staff_id,
                'note'=>$noted,
                'zone_id'=>$zoneID
            ]);
		}else{	
			$insertInv=tbl_sale_invs::create([
				'user_id'=>$userid,
				'status'=>0,
				'toDate'=>$dateRequest,
				'invoid_code'=>$invoidCode,
                'staff_id'=>$staff_id,
                'note'=>$noted,
                'zone_id'=>$zoneID
			]);
			$saved = $insertInv->save();

			if($saved){
                foreach ($item_id as $key => $value) {
    				tbl_sale_details::create([
    					'sale_inv_id'=>$insertInv->id,
    					'item_id'=>$value,
                        'unit_price'=>$unit_price[$key],
    					'qty'=>$item_qty[$key]
    				]);
                }
			}
		}
	}
    
    public function requestManagement(){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',0)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',1)->orwhere('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::getSaleInvAll();
        $getSaleInv = tbl_sale_invs::orderBy('id','desc')->get();

        return view('stockRequest.requestManagement')->with(array('getSaleInv'=>$getSaleInv,'countRequest'=>$countRequest));
    }
    public function listRequestManagement($status){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',0)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',1)->orwhere('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::getSaleInvAll();

        if($status==2){
            $getSaleInv = tbl_sale_invs::orderBy('id','desc')->get();
        }elseif($status==1){
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',1)->orwhere('status',2)->get();
        }else{
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',$status)->get();
        }

        return view('stockRequest.requestManagement')->with(array(
                                                    'getSaleInv'=>$getSaleInv,
                                                    'countRequest'=>$countRequest,
                                                    'status'=>$status));
    }
    public function approvrequest($id){
        $query = tbl_sale_invs::where('id',$id)->update(['status'=>1]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }

    public function rejectrequest($id){
        $query = tbl_sale_invs::where('id',$id)->update(['is_actived'=>1]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }
    public function managerapprov(){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',0)->orwhere('status',1)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::getSaleInvAll();
        $getSaleInv = tbl_sale_invs::orderBy('id','desc')->get();

        return view('stockRequest.managerApprov')->with(array('getSaleInv'=>$getSaleInv,'countRequest'=>$countRequest));
    }
    public function listmanagerapprov($status){
        $countRequest=array();
        $countRequest[0]=tbl_sale_invs::where('status',0)->orwhere('status',1)->get()->count();
        $countRequest[1]=tbl_sale_invs::where('status',2)->get()->count();
        $countRequest[2]=tbl_sale_invs::getSaleInvAll();

        if($status==2){
            $getSaleInv = tbl_sale_invs::orderBy('id','desc')->get();
        }elseif($status==1){
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',2)->get();
        }else{
            $getSaleInv=tbl_sale_invs::orderBy('id','desc')->where('status',0)->orwhere('status',1)->get();
        }

        return view('stockRequest.managerApprov')->with(array(
                                                    'getSaleInv'=>$getSaleInv,
                                                    'countRequest'=>$countRequest,
                                                    'status'=>$status));
    }
    public function approvbymanager($id){
        $query = tbl_sale_invs::where('id',$id)->update(['status'=>2]);
        if($query){
            echo 'yes';
        }else{
            echo 'no';
        }
    }
}

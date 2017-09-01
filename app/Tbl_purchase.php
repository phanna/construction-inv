<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tbl_purchase extends Model
{
    //
    protected $table = 'tbl_purchase';
    
    protected $fillable =[
    	'user_id',
    	'supl_id',
    	'staff_id',
    	'purchase_code',
    	'total_price',
    	'status',
    	'purchase_date',
        'note',
        'purchase_note',
        'zone_id'
    ];

    public static function PurchaseStatusNot2IsActive0(){
        $query = DB::table('tbl_suppliers')
                ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
                ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
                ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
                ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
                ->orderBy('tbl_purchase.id','desc')
                ->where('status','!=',2)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatusNot3(){
        $query = DB::table('tbl_suppliers')
                ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
                ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
                ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
                ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
                ->orderBy('tbl_purchase.id','desc')
                ->where('status','!=',3)->get();
        return $query;
    }
    public static function PurchaseStatus3(){
        $query = DB::table('tbl_suppliers')
                ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
                ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
                ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
                ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
                ->orderBy('tbl_purchase.id','desc')
                ->where('status',3)->get();
        return $query;
    }
    public static function PurchaseStatusnot0(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status','!=',0)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatus(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->get();
        return $query;
    }
    public static function PurchaseStatus0(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',0)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatus1(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',1)->where('is_actived',0)->get();
        return $query;
    }
     public static function PurchaseStatus0or1(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',0)->where('is_actived',0)->orwhere('status',1)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatus1or2(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',1)->orwhere('status',2)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatus2(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',2)->where('is_actived',0)->get();
        return $query;
    }
    public static function PurchaseStatus2or3(){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',2)->where('is_actived',0)->orwhere('status',3)->get();
        return $query;
    }
    public static function PurchaseStatusall($status){
        $query = DB::table('tbl_suppliers')
            ->select('tbl_purchase.*','tbl_suppliers.company_name','tbl_staffs.staff_name','tbl_zones.zone')
            ->join('tbl_purchase', 'tbl_purchase.supl_id', '=', 'tbl_suppliers.id')
            ->join('tbl_staffs', 'tbl_purchase.staff_id','=','tbl_staffs.id')
            ->join('tbl_zones', 'tbl_purchase.zone_id','=','tbl_zones.id')
            ->orderBy('tbl_purchase.id','desc')
            ->where('status',$status)->where('is_actived',0)->get();
        return $query;
    }
    public static function listPurchaseItem($id){
        $query = DB::table('tbl_items')
            ->select('tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_purchase_detail.*')
            ->join('tbl_purchase_detail', 'tbl_purchase_detail.item_id', '=', 'tbl_items.id')
            ->orderBy('tbl_purchase_detail.id','desc')
            ->where('tbl_purchase_detail.purchase_id',$id)->get();
        return $query;
    }
    public static function listPurchasDetail($id){
        $query = DB::table('tbl_items')
                ->select('tbl_purchase.purchase_date','tbl_purchase.zone_id','tbl_purchase.note','tbl_purchase.staff_id','tbl_purchase.supl_id','tbl_items.id','tbl_items.item_code','tbl_items.item_name','tbl_items.item_measure','tbl_purchase_detail.purchase_id','tbl_purchase_detail.unit_price','tbl_purchase_detail.item_id','tbl_purchase_detail.qty')
                ->join('tbl_purchase_detail', 'tbl_purchase_detail.item_id', '=', 'tbl_items.id')
                ->join('tbl_purchase','tbl_purchase_detail.purchase_id','=','tbl_purchase.id')
                ->orderBy('tbl_purchase_detail.id','desc')
                ->where('tbl_purchase_detail.purchase_id',$id)->get();
        return $query;
    }

    public static function itemPurchaseIn(){
        $todayDate = date("Y-m-d");
        $query = DB::table('tbl_items')
                ->select('tbl_items.item_code','tbl_staffs.staff_name','tbl_items.item_name','tbl_purchase_detail.qty')
                ->join('tbl_purchase_detail', 'tbl_purchase_detail.item_id', '=', 'tbl_items.id')
                ->join('tbl_purchase','tbl_purchase.id','=','tbl_purchase_detail.purchase_id')
                ->join('tbl_staffs','tbl_staffs.id','=','tbl_purchase.staff_id')
                ->orderBy('tbl_purchase.id','desc')
                ->where('tbl_purchase.status',3)
                ->where('tbl_purchase.purchase_date',$todayDate)->get();
        return $query;
    }
}

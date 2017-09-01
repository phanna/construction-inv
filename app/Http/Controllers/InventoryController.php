<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Tbl_item;
use Auth;
use Carbon;
use App\Tbl_Item_Stock;
use App\ItemCategory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
		$catID=request('categoryID');
		if(empty($catID)){
			$query=Tbl_item::where('is_actived',0)
                            ->orderBy('created_at','DESC')->get();
		}else{
			$query=Tbl_item::where('is_actived',0)
                            ->where('item_category_id',$catID)
                            ->orderBy('created_at','DESC')->get();
		}
		
        return view('inventory.inventory')->with(array('queryItem'=>$query,'cateID'=>$catID));
    }

    public function addNewItem(){
		$getInv=Tbl_item::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', date('n'))->get();//where('user_id',$userid)->
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
		$title='New Item';
        return view('vendor.newItem')->with(array('barcode'=>$newInv,'title'=>$title));
    }
	
	public function editItem($id)
    {
        //
		$title='Edit Item';
        $getItem = Tbl_item::where('id',$id)->get();
        return view('vendor.newItem')->with(array('getItemEdit'=>$getItem,'title'=>$title));
    }
	
    public function existItemCode(){
        echo 'true';
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
		$datefrom = Carbon\Carbon::parse(request('datefrom'));
		$dateto = Carbon\Carbon::parse(request('dateto'));
        $datePurchase = Carbon\Carbon::parse(request('datePurches'));
		$currentdate = Carbon\Carbon::now();
		
        $checkItemID = request('itemID');
        $oldImg = request('photo');
        $image = $request->image;
        
        if(empty($image)){
            $imageName = request('photo');
        }else{
            $extension = $request->image->getClientOriginalExtension();
            $file_path = 'uploads/'.$oldImg;
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            @unlink($file_path);
        }
        if($checkItemID){
            Tbl_item::where('id',$checkItemID)
            ->update([
                'user_id'=>Auth::user()->id,
                'item_category_id'=>1,
                'item_code'=>request('barcode'),
                'item_name'=>request('itemname'),
                'description'=>request('description'),
                'item_measure'=>request('measur'),
                'item_category_id'=>request('categoryID'),
                'photo'=>$imageName
                
            ]);
			
        }else{
		    Tbl_item::create([
                'user_id'=>Auth::user()->id,
                'item_category_id'=>1,
                'item_code'=>request('barcode'),
                'item_name'=>request('itemname'),
                'description'=>request('description'),
                'item_measure'=>request('measur'),
                'item_category_id'=>request('categoryID'),
                'photo'=>$imageName,
              
            ]);
        }
		
		
    }
	
	//check stock by item
	public function get_stock_eachItem($item_id){
		//echo $item_id;
		$query=Tbl_item::all();
		return $query[0]->getCountItemStock($item_id);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function selectItemByCateogry()
    {
        //
		
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    //manage stock
    public function showStock($id){
        $itemInv = Tbl_item::where('id',$id)->get();
		$totalItemStock=$itemInv[0]->getCountItemStock($id);
        $itemStock = Tbl_Item_Stock::where('item_id',$id)->get();
		$query=ItemCategory::get();
        $array_category=array();
        foreach($query as $obj){
                $array_category[$obj->id]=$obj->category_name;
            }

        return view('inventory.inventoryStock')
                ->with(array(
                        "itemID"=>$itemInv,
                        "itemStock"=>$itemStock,
                        "array_category"=>$array_category,
						"totalStock"=>$totalItemStock
                    ));
    }
    public function modalStock($itemID,$status){
        $itemInv = Tbl_item::where('id',$itemID)->get();
        return view('vendor.newStock')->with(array("itemID"=>$itemInv,"status"=>$status));
    }
    public function selectStock($itemID,$id,$status){
        $itemInv = Tbl_item::where('id',$itemID)->get();
        $getStock = Tbl_Item_Stock::where('id',$id)->get();
        return view('vendor.newStock')->with(array(
                                    "itemID"=>$itemInv,
                                    "getStock"=>$getStock,
                                    "status"=>$status
                                ));
    }
    public function createStock(){
		$datePurchase = Carbon\Carbon::parse(request('datePurches'));
        $itemID = request('itemID');
        $status = request('status');
        $stockid = request('stockID');
        if($stockid){
            Tbl_Item_Stock::where('id',$stockid)
                ->where('status',$status)
                ->update([
                'item_id'=>$itemID,
                'status'=>request('status'),
                'amount'=>request('stock'),
                'unit_price'=>request('price'),
                'item_measure'=>request('measur'),
                'purchase_date'=>$datePurchase
            ]);
        }else{
            Tbl_Item_Stock::create([
                'item_id'=>$itemID,
    			'status'=>request('status'),
                'amount'=>request('stock'),
                'unit_price'=>request('price'),
                'item_measure'=>request('measur'),
    			'purchase_date'=>$datePurchase
            ]);
        }
    }
    public function distroyStock(){
        $id = request('stock_id');
        $delete = Tbl_Item_Stock::where('id', $id)->delete();
        if($delete){
            return 'yes';
        }else{
            return 'no';
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use App\Menus;
use App\tbl_sale_invs;

use App\Tbl_item;
use Auth;
use View;
use Carbon;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	//autocompletd customer
	
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$userid=Auth::user()->id;
		$getInv=tbl_sale_invs::where('status',0)->get();//where('user_id',$userid)->
		$getCountInv=$getInv->count()+1;
		$newInv="";
		
		if($getCountInv>=1000){
				$newInv='Req-'.$getCountInv;
				
			}else if($getCountInv>=100){
				$newInv='Req-0'.$getCountInv;
			}else if($getCountInv>=10){
				$newInv='Req-00'.$getCountInv;
			}else if($getCountInv<10 && $getCountInv>0){
				$newInv='Req-000'.$getCountInv;
			}else{
					$newInv='Req-0001';
			}
			//	dd($newInv);,$newInv
		//return redirect('/sale/invoice/'.$newInv);
       return view('sales.saleForm')->with('invoiceNumber',md5($newInv));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function addItemToStaff($staffID){
	 	$arrayItem = array();
        $query = tbl_sale_invs::get();
        $array_category=array();
        foreach($query as $obj){
            $arrayItem[$obj->id]=$obj->item_id;
        }
        
	 	$queriesItem = DB::table('tbl_items')
		//	->join('tbl_sale_details', 'tbl_sale_details.item_id', '=', 'tbl_items.id')
			->join('tbl_sale_invs', 'tbl_sale_invs.item_id', '=', 'tbl_items.id')
			->select('tbl_items.*','tbl_sale_invs.toDate')
			->where('tbl_sale_invs.staff_id',$staffID)
			->orderBy('tbl_sale_invs.id', 'DESC')->get();
		//	print_r($queriesItem);
			return view('sales.saleForm')->with(array(
									'staffid'=>$staffID,
									'queryItem'=>$queriesItem,
									'arrayItems'=>$arrayItem
								));
	
	}
    public function selectItem_NewInvoice()
    {
        //
        $userid = Auth::user()->id;
		$staffID=request('q');
		$item_barcode=request('item_barcode');
		if(!empty($item_barcode)){
				$itemQuery=Tbl_item::where('item_code',$item_barcode)->get();
				if($itemQuery->count()>0){
						$item_id=$itemQuery[0]->id;
					}else{
						echo 'no';
						exit;
					}
				
			}else{
				$item_id=request('item_id');
				}
		//echo $item_id;
		//dd($item_id);
        $dateto = Carbon\Carbon::now();
		
		//dd($invInsertId);
		if(!empty($item_id) && !empty($staffID)){
			$insertInv=tbl_sale_invs::create([
			
					'user_id'=>$userid,
					'staff_id'=>$staffID,
					'item_id'=>$item_id,
					'toDate'=>$dateto,
					'qty'=>1
				]);
		}
		//query back
		$queriesItem = DB::table('tbl_items')
				->join('tbl_sale_invs', 'tbl_sale_invs.item_id', '=', 'tbl_items.id')
				->select('tbl_items.*','tbl_sale_invs.toDate')
				->where('tbl_sale_invs.staff_id',$staffID)
				->orderBy('tbl_sale_invs.id', 'DESC')->get();
		//print_r($insertInv);
		//echo '<pre>';
		return $queriesItem;	
		//return redirect()->route('profile', ['id' => 1]);
		//return redirect('/sale/show/'.$invInsertId);
		//return \Redirect::route('/sale/show', $invInsertId)->with('invInsertId', 'State saved correctly!!!');
	  
    }
	//update date and time
	public function fn_Update_invoice(){
			$invId=request('');
			$newDate=request('');
			$dateto = Carbon\Carbon::parse($newDate);
			Tbl_staffs::where('id', $invId)
                ->update([  
                    'toDate'=>$dateto
                ]);
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
	public function show($id){
		//dd($id);
		$saleInv=tbl_sale_invs::find($id);
		return view('sales.saleForm')->with('parent',$saleInv);
			
	}
    public function show_item()
    {
			$item_code = request('item_code');
			if(!empty(trim($item_code))){
				$queries = DB::table('tbl_items')
				//->join('tbl_item_details', 'tbl_items.id', '=', 'tbl_item_details.item_id')
				
				->select('tbl_items.*')
				->where('tbl_items.item_code',$item_code);

				if($queries->count()>0){
					
						return $queries->get();
					}else{
						echo 'false1';
						}
			}else{
				echo 'false2';
				}
				//dd($queries);
    }
	//insert New item
	public function store_item()
    {
			$newItemCode=request('newItemCode');
			$newItemName=request('newItemName');
			$isPurchase=request('isPurchase');
			$pUnitPrice=request('pUnitPrice');
			$pAccountID=request('pAccountID');
			$pTax_item_id=request('pTax_item_id');
			$isSale=request('isSale');
			$sUnitPrice=request('sUnitPrice');
			$sAccountID=request('sAccountID');
			$stax_item_id=request('stax_item_id');
			
			$this->validate(request(),[
					'newItemCode' => 'required|unique:tbl_items,item_code',
					'newItemName' => 'required',
					'sUnitPrice' => 'required',
				]);
			 $insertItem=Tbl_item::create([
			 	'company_id'=>Auth::user()->company_id,
				'item_code'=>request('newItemCode'),
				'item_name'=>request('newItemName')
			]);
			//'inventory_type'=>1 is sale ------- 2= purchase
			$item_id=$insertItem->id;
			Tbl_item_detail::create([
				'item_id'=>$item_id,
				'unit_price'=>request('sUnitPrice'),
				'inventory_type'=>1
			]);
			if(isset($pTax_item_id) || !empty($pTax_item_id)){
				$item_id=$insertItem->id;
					Tbl_item_detail::create([
						'item_id'=>$item_id,
						'cost_price'=>request('pUnitPrice'),
						'inventory_type'=>2
					]);
				}
			//return item code
    }
	public function existItemCode(){
		$item_code = request('newItemCode');
			$queries =Tbl_item::where('item_code',$item_code)->count();
			//dd($item_code);
			if ($queries > 0){
					echo 'false';
				}
				else{
					echo 'true';
				}
		}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
        $itemid = request('item_id');
        $staffID = request('staff_id');

        $query = tbl_sale_invs::where('staff_id',$staffID)
        						->where('item_id',$itemid)
                				->delete();

       	if($query){
            return 'yes';
        }else{
            return 'no';
        }

    }
}

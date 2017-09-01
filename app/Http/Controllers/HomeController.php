<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Menus;
use View;
use Auth;
use Redirect;
use App\Tbl_item;
use App\tbl_sale_invs;
use App\Tbl_purchase;
use App\Tbl_department;
use Carbon\Carbon;
use App\Tbl_Post;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
	private $result;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		// View::share ( 'menus', 'I am Data 3' );
      // return view('home');
		$user = Auth::user();
		if($user){
			
				$array_dashboard=array('Staff','Inventory','Inventory ('.date('M').')','Total Room','Total Staff','Department');
				$array_color=array('87d8c4','60bda8','3b9984','25826d','156854','044031');
				
				// $totalStaff=Tbl_staffs::all()->count();
				$totalDiv=Tbl_department::all()->count();
				
				$totalItem=Tbl_item::all()->count();
				$totalItemByMonth=Tbl_item::whereMonth('created_at','=',date('n'))->count();
				
				// $totalRoom=Tbl_Condo::all()->count();
				// $totalStaff=Tbl_staffs::all()->count();
				
				$array_data=array($totalItem,$totalItemByMonth,$totalDiv);
				//dd($issetUser);
				
				//Staff Data
				$dateS = new Carbon('first day of January 2017');
				$dateE = new Carbon('first day of November 2017');
				
				//dd($dateS->format('Y-m-d')." 00:00:00");
			//	$queryStaffData=Tbl_item::whereBetween('created_at','=', [$dateS->format('Y-m-d')." 00:00:00"], [$dateE->format('Y-m-d')." 23:59:59"])->get();
				
				//dd($queryStaffData);
				$jsonFloor=array();
				
				$arrayDrill2=array();
				$arrayDrill3=array();
				/*foreach(Tbl_Condo_Floor::all() as $objF){
					
					if($objF->getCondo->count()>0){
						$y=$objF->getCondo->count();
						$jsonFloor[]=array('name'=>"'".$objF->floor."'", 'y'=>$y,'drilldown'=>$objF->id);
						$jsonDrill=array();
							foreach($objF->getCondo as $objR){
								//check inventory
								$totalINV=$objR->getCountItem($objR->id);
								$jsonDrill[]="['".$objR->condo_name."',".$totalINV."]";
							}
						
						$arrayDrill2[]=array('name'=>"'Inventory'",'id'=>$objF->id,'data'=>$jsonDrill);
						
					}
					
				}*/
				
			//	$c=array_merge($arrayDrill3,$arrayDrill2);
				$series=preg_replace('/"/','',json_encode($jsonFloor,JSON_NUMERIC_CHECK));
				$drilldown=preg_replace('/"/','',json_encode($arrayDrill2,JSON_PRETTY_PRINT));
				$array_chart_room=array($series,$drilldown);
				
				//chart
				$chartquery = tbl_sale_invs::CountZone();

				// $jsondata = json_encode($chartquery);
				$chartreplace = preg_replace('/"/','',$chartquery);

				$itemRequest = tbl_sale_invs::itemRequestToday();
				$itemPurchase = Tbl_purchase::itemPurchaseIn();

				return view('home')->with(array(
							'array_dashboard'=>$array_dashboard,
							'array_color'=>$array_color,
							'array_data'=>$array_data,
							'chartreplace'=>$chartreplace,
							'itemRequest'=>$itemRequest,
							'itemPurchase'=>$itemPurchase
							)
						);
				
			
		}
    }
	public function meeting(){
			return view('meeting');
		}
	public function meeting_($id){
			$query=Tbl_Post::where('id',$id)->get();
			return view('meeting');
		}
	public function addpost(Request $request){
			 Tbl_Post::create([
                'user_id'=>Auth::user()->id,
                'title'=>request('title')
              
            ]);
		}
	
	public function barcodeGenerator(){
			return view('vendor.barcodeGengerator');
		}

}

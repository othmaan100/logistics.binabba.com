<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Truck;
use App\Models\Good;
use App\Models\client;
use App\Models\GoodsType;
use App\Models\Payment;
use App\Models\Drivers;
use PDF;

class GoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       
        //$goods = Good::all();
        $goods=DB::table('tbl_good')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->whereNull('tbl_good.good_date_of_delivery')
                     ->orderBy('tbl_good.good_date_of_pickup','ASC')
                     ->get();
                     //->simplePaginate(5); 
        $dgoods=DB::table('tbl_good')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->whereNotNull('tbl_good.good_date_of_delivery')
                     ->get();
                     //->simplePaginate(5); 
        //return $dgoods;
        return view('admin.goods', compact('goods','dgoods'));

    }

    public function indexpdf()
    {
        # code...
         $goods=DB::table('tbl_good')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->whereNull('tbl_good.good_date_of_delivery')
                     ->get();

        //return $dgoods;
         PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
       
       $pdf = PDF::loadView('admin.goods.indexpdf', compact('goods'));
      
        return $pdf->download('Undilivered_good_list.pdf');

    }
     public function indexdpdf()
    {
        # code...
        $dgoods=DB::table('tbl_good')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->whereNotNull('tbl_good.good_date_of_delivery')
                     ->get();
        //return $dgoods;
        //return view('goods.indexdpdf', compact('dgoods'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
       $pdf = PDF::loadView('admin.goods.indexdpdf', compact('dgoods'));
        return $pdf->download('Delivered_good_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $trucks = Truck::all();
        $clients = client::all();
        $goodsTypes=GoodsType::orderBy('goods_type','ASC')->get();
        // $companies=FuelDebt::all()->unique('company');

        $count=count(Good::all()) +1;
         $count++;

          $pcount=count(Payment::all());
         $pcount++;

        return view('admin.creategoods', compact('trucks','clients','count','goodsTypes','pcount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //,
 
        $request->validate([

            'good_id_no' => 'required|unique:tbl_good',
            'truck_id' => 'required',
            'good_type' => 'required',
            'good_weight' => 'required',
            'good_cost' => 'required',
            'diesel_cost' => 'required',
            'liters' => 'required',
            'commission' => 'required',
            'road_expenses' => 'required',
            'client_id' => 'required',
            'good_date_of_pickup' => 'required',
            'good_pickup_point' => 'required',
            'good_delivery_point' => 'required',

            'payment_id_no' => 'required',
            'payment_mode' => 'required|string',
            
    
            ]);

            $good= new Good;
            $good->good_id_no= $request->input('good_id_no');
            $good->truck_id=  $request->input('truck_id');
            $good->driver_id=  $request->input('driver_id_no');
            $g_type=  $request->input('good_type'); 
            $g_weight=  $request->input('good_weight');
            
            if ($g_type=='Others') {
                # code...
                $good->good_type=  $request->input('other_type');
                $goodstype= new GoodsType;
                $goodstype->goods_type=   $request->input('other_type');
                $goodstype->save();
            }else{
                $good->good_type=  $request->input('good_type');
            }

            if ($g_weight=='Others') {
                # code...
                $good->good_weight=  $request->input('other_weight');
                
            }else{
                $good->good_weight=  $request->input('good_weight');
           }

            
            $good->liters=  $request->input('liters');
            $good->good_cost=  $request->input('good_cost');
             
            $gcost= $request->input('good_cost');
            $good->diesel_cost=  $request->input('diesel_cost');
            
            $goodComission =  $request->input('commission');
            if ($goodComission!=0) {
                # code...
                $good->commission = $gcost*0.1;
            
            }else{
                $good->commission=  $request->input('commission');
            }

            $good->road_expenses=  $request->input('road_expenses');
            $good->client_id=  $request->input('client_id');
            $good->good_date_of_pickup = $request->input('good_date_of_pickup');
            $good->good_date_of_delivery = $request->input('good_date_of_delivery');
            $good->good_pickup_point = $request->input('good_pickup_point');
            $good->good_delivery_point = $request->input('good_delivery_point');
            $good->save();

             $payment= new Payment;
            $payment->payment_id_no= $request->input('payment_id_no');
            $payment->payment_mode= $request->input('payment_mode');
            $gid=$good->good_id;
            $payment->good_id= $gid;
            $payment->client_id = $request->input('client_id');
            $pm=$request->input('payment_mode');
            if ($pm=='FP' or $pm=='BP') {
                # code...
                $num= $request->input('good_cost');
                $amount=filter_var($num,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $payment->payment_deposit =$amount;
                $payment->payment_status='1';

                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 1]);


            }else {
                # code...
                $payment->payment_deposit = $payment->payment_deposit + $request->input('payment_deposit');
                

            }
           
            $payment->payment_mode=  $request->input('payment_mode');
            
            
            $payment->save();
           /*  $goodinfo= Good::find($gid);
            $goodCost=$goodinfo->good_cost;
 */
            $goodinfo= Good::find($gid);
            $goodCost=$goodinfo->good_cost;

            $pid= $payment->payment_id;
           
            $payinfo= Payment::find($pid);
            $gooddeposit=$payinfo->payment_deposit;

            if ($gooddeposit >= $goodCost) {
                # code...
                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 1]);
                $updatepay = DB::table('tbl_payment')
                        ->where('payment_id', $pid)
                        ->update(['payment_status' => 1]);
            }


            
            /* return redirect('/posts')->with('success', 'Post Created');

    
            goods::create($request->all()); */
    
            return redirect()->route('admin-goods.index')
    
                    ->with('success','Good Added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function show($good)
    {
        //
          $good=DB::table('tbl_good')
                     ->leftJoin('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->leftJoin('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->leftJoin('trucks','trucks.id','tbl_good.truck_id')
                     ->select('tbl_good.*','tbl_clients.client_name','tbl_drivers.driver_name','trucks.truck_model','trucks.plate_number')
                     ->where('tbl_good.good_id',$good)
                     ->get();
        //return $good;

        abort_if($good->isEmpty(), 404);

        return view('goods.showgoods',compact('good'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(string $good)
    {
        //
        
              $selected = "";
        
         /*$good=DB::table('tbl_good')
                    ->join('trucks','trucks.id','tbl_good.truck_id')
                    ->join('tbl_drivers','tbl_drivers.driver_id_no','trucks.driver_id_no')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                    ->where('tbl_good.good_id',$good)
                     ->get();*/
        $good= Good::find($good);
      
        $good_id=$good->good_id;
        
        $driver_id =$good->driver_id;
       
        $truck_id =$good->truck_id;
        
        $client_id =$good->client_id;
        
         $trucks=Truck::find($truck_id);
       //return $driver_id;
       $driver=Drivers::find($driver_id);
       
       $driver_name=$driver->driver_name;
       
           $aclients=client::all();
          
          $clients=client::find($client_id);

          $gpayment= Payment::all();
          $payment= Payment::where('good_id', $good_id)->get();
          // $payment= $gpayment->where('good_id', $good_id);
       /* $payment= BD::table('tbl_payment')
                    ->where('good_id', $good_id)
                    ->get();*/
       // return  $payment;
    
        return view('admin.editgoods',compact('good','trucks','clients','driver_name','aclients','payment'))->with('selected',$selected);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        //
       // return $id;
        $request->validate([
           
            'good_type' => 'required',
            'good_weight' => 'required',
            'good_cost' => 'required',
            'diesel_cost' => 'required',
            'liters' => 'required',
            'road_expenses' => 'required',
            'good_date_of_pickup' => 'required',
            'good_pickup_point' => 'required',
            'good_delivery_point' => 'required',
             'commission' => 'required',

             'payment_id' => 'required',
            'payment_mode' => 'required|string',
            
    
            ]);

            $good= Good::find($id);
            $good->good_type=  $request->input('good_type');    
            $good->good_weight=  $request->input('good_weight');       
            $good->liters=  $request->input('liters');
            $good->good_cost=  $request->input('good_cost');     
            $gcost= $request->input('good_cost');
            $good->diesel_cost=  $request->input('diesel_cost');
            
            $goodComission =  $request->input('commission');
            if ($goodComission!=0) {
                # code...
                $good->commission = $gcost*0.1;
            
            }else{
                $good->commission=  $request->input('commission');
            }

            $good->road_expenses=  $request->input('road_expenses');
            $good->client_id=  $request->input('client_id');
            $good->good_date_of_pickup = $request->input('good_date_of_pickup');
            $good->good_pickup_point = $request->input('good_pickup_point');
            $good->good_delivery_point = $request->input('good_delivery_point');
            $good->save();
            $payment_id=$request->input('payment_id');

            $payment= Payment::find($payment_id);
           
            $payment->payment_mode= $request->input('payment_mode');
            $gid=$good->good_id;
            $payment->good_id= $gid;
            $payment->client_id = $request->input('client_id');
            $pm=$request->input('payment_mode');
            if ($pm=='FP' or $pm=='BP') {
                # code...
                $num= $request->input('good_cost');
                $amount=filter_var($num,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $payment->payment_deposit =$amount;
                $payment->payment_status='1';

                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 1]);


            }else {
                # code...
                $payment->payment_deposit = $request->input('payment_deposit');
                
  
            }
           
            $payment->payment_mode=  $request->input('payment_mode');
            
            
            $payment->save();
             $goodinfo= Good::find($gid);
            $goodCost=$goodinfo->good_cost;
             $goodinfo= Good::find($gid);
            $goodCost=$goodinfo->good_cost;

            $pid= $payment->payment_id;
           
            $payinfo= Payment::find($pid);
            $gooddeposit=$payinfo->payment_deposit;

            if ($gooddeposit >= $goodCost) {
                # code...
                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 1]);
                $updatepay = DB::table('tbl_payment')
                        ->where('payment_id', $pid)
                        ->update(['payment_status' => 1]);

            }else{

                  # code...
                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 0]);
                $updatepay = DB::table('tbl_payment')
                        ->where('payment_id', $pid)
                        ->update(['payment_status' => 0]);


            }











    
           // $good->update($request->all());
    
            return redirect()->route('admin-goods.index')->with('success','Good information updated successfully');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Good $good)
    {
        //
        $goods->delete();



        return redirect()->route('goods.index')

                ->with('success','Good Record deleted successfully');

    }

    public function TruckfetchDriver(Request $request)
    {
        $truck_id=$request['truck_id'];
         $good = Truck::where('id',$truck_id)->firstOrFail();
          //dd($good); 
         $driver_id_no= $good->driver_id_no;
         $driver = Drivers::where('driver_id_no',$driver_id_no)->firstOrFail();
         $driver_name=$driver->driver_name; 
         $driver_id= $driver->driver_id;
          echo '<label for="driver_name" class="font-weight-bold">Driver Name:</label>
         <input type="hidden" class="form-control" name="driver_id_no" value="'.$driver_id .'" id="driver_id_no"  readonly/>
         <input type="text" class="form-control" value="'. $driver_name .'" name="driver_name" id="driver_name"  readonly/>';
 ; 
    }

public function goodDelivered($goodid)
{
    # code...
    $date= Date('d-m-Y');
     $updateGood = DB::table('tbl_good')
    ->where('good_id', $goodid)
    ->update(['good_date_of_delivery' => $date ]); 
    
    return redirect()->route('admin-goods.index')
                    ->with('success','Good Delivery Record updated successfully');

}
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Truck;
use App\Models\Drivers;
use PDF;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $trucks = DB::table('trucks')
                    ->join('tbl_drivers', function ($join){
                        $join->on('tbl_drivers.driver_id_no','=','trucks.driver_id_no'); 
                    })->get();

         $ntrucks = DB::table('trucks')
                    ->where('driver_id_no',"") 
                    ->orwhere('driver_id_no',NULL)
                    ->get(); 
        

        return view('admin.trucks', compact('trucks','ntrucks'));
    }

    public function indexpdf()
    {
        # code...
         # code...
        $trucks = Truck::all();
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('trucks.indexpdf', compact('trucks'));
        return $pdf->download('truck_list.pdf');
      
       // return view('trucks.indexpdf', compact('trucks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $drivers = Drivers::all();
        return view('admin.createtrucks', compact('drivers'));
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
        $request->validate([

            'plate_number' => 'required',
            'truck_model' => 'string',
            'truck_price' => 'int',
            
            
            
    
            ]);

            $truck= new Truck;
            $truck->truck_model= $request->input('truck_model');
            $truck->driver_id_no= $request->input('driver_id');
            $truck->plate_number = $request->input('plate_number');
            $truck->truck_price = $request->input('truck_price');
            $truck->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            trucks::create($request->all()); */
    
            return redirect()->route('admin-trucks.index')
                    ->with('success','Truck added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
   // public function show(Truck $truck)
    public function show( $truck)
    {
        //
         # code...
 //     
        

        $truck = Truck::find($truck);
        return view('trucks.show',compact('truck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        //
        $drivers = Drivers::all();
        $truck = Truck::find($id);
        //return $truck;
        return view('admin.trucksedit', ['truck' => $truck,'drivers' => $drivers]);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'plate_number' => 'required',
            'truck_model' => 'string',
            
            ]);

            $truck = Truck::find($id);
            $truck->plate_number       = $request->get('plate_number');
            $truck->truck_model      = $request->get('truck_model');
            $truck->driver_id_no= $request->get('driver_id_no');
            $truck->save();


    
            return redirect()->route('admin-trucks.index', ['truck' => $truck])->with('success','Truck information updated successfully');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        //
        $truck->delete();



        return redirect()->route('trucks.index')

                ->with('success','truck Recor deleted successfully');

    }

    public function operations($truckid)
    {
        # code...
        $truck= Truck::find($truckid);

         $expenses = DB::table('expenses')
                        ->join('tbl_good','tbl_good.good_id','expenses.good_id')
                        ->where('tbl_good.truck_id',$truckid) 
                        ->get();

        $truckValue= $truck->truck_price;

        $texpenses=$expenses->sum('expenses_cost');
        //return $texpenses;

        $TG = Truck::find($truckid)->myGood;
        $total_cost = $TG->sum('good_cost'); 

        
        //return $total_commission;
         $total_road_expenses= $TG->sum(fn ($g) => (float) $g->road_expenses); 
         
         $total_commission= $TG->sum(fn ($g) => (float) $g->commission); 

         $total_diesel_cost = DB::table('tbl_good')
                                ->join('trucks', 'trucks.id', '=', 'tbl_good.truck_id')
                                ->select(DB::raw('sum(tbl_good.diesel_cost*tbl_good.liters) AS diesel_total'))
                                ->where('trucks.id', $truckid)
                                ->get()
                                ->pluck('diesel_total');

        
         $total_diesel_cost = $total_diesel_cost[0];

         

       
        $t_expenses = $total_diesel_cost + $total_road_expenses +  $total_commission+ $texpenses;
        
        //return $t_expenses;

        $ammount_obtained = $total_cost - $t_expenses;
        $drivers_percent= $ammount_obtained *0.1;

        $total_expenses= $t_expenses + $drivers_percent;
        //
        $total_amount_generated= $ammount_obtained- $drivers_percent;

        $balance=  $truckValue - $total_amount_generated;

        // return $balance;
            
      
          $profit=$total_amount_generated-$truckValue;
          //return $profit;
        return view('admin.operations', compact('truck','total_cost','total_expenses','profit','total_amount_generated','truckValue','balance'))->with('goods',$TG);

    }


    public function operationspdf($truckid)
    {
        # code...
        $truck= Truck::find($truckid);

         $expenses = DB::table('expenses')
                        ->join('tbl_good','tbl_good.good_id','expenses.good_id')
                        ->where('tbl_good.truck_id',$truckid) 
                        ->get();

        $truckValue= $truck->truck_price;

        $texpenses=$expenses->sum('expenses_cost');
        //return $texpenses;

        $TG = Truck::find($truckid)->myGood;

        $goods =$TG;
         $total_cost = $TG->sum('good_cost'); 


         $total_road_expenses= $TG->sum(fn ($g) => (float) $g->road_expenses); 
         $total_commission= $TG->sum(fn ($g) => (float) $g->commission); 

         $total_diesel_cost = DB::table('tbl_good')
                                ->join('trucks', 'trucks.id', '=', 'tbl_good.truck_id')
                                ->select(DB::raw('sum(tbl_good.diesel_cost*tbl_good.liters) AS diesel_total'))
                                ->where('trucks.id', $truckid)
                                ->get()
                                ->pluck('diesel_total');

        
         $total_diesel_cost = $total_diesel_cost[0];

         

       
         $t_expenses = $total_diesel_cost + $total_road_expenses +  $total_commission+ $texpenses;
        //return $TG;
         $ammount_obtained = $total_cost - $t_expenses;
         $drivers_percent= $ammount_obtained *0.1;

         $total_expenses= $t_expenses + $drivers_percent;
         //
         $total_amount_generated= $ammount_obtained- $drivers_percent;

         $balance=  $truckValue - $total_amount_generated;

        // return $balance;
            
      
          $profit=$total_amount_generated-$truckValue;
          //return $profit;
          PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

         // return view('admin.trucks.operationspdf', compact('truck','total_cost','total_expenses','profit','total_amount_generated','truckValue','balance','goods'));

       
        $pdf = PDF::loadView('admin.trucks.operationspdf', compact('truck','total_cost','total_expenses','profit','total_amount_generated','truckValue','balance','goods'));



         ///$pdf = PDF::loadView('trucks.operationspdf', compact('truck','total_cost','total_expenses','profit','goods'));
         return $pdf->download('trucks_operations.pdf');



    }
}

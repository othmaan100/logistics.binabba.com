<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Good;
use App\Models\GoodsType;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\client;
use App\Models\Drivers;
use App\Models\Truck;
use App\Models\Payment;
use App\Models\filling_station;
use App\Models\FuelDebt;


use PDF;
use NumberToWords\NumberToWords;
use Illuminate\View\View;
use App\Services\TruckPerformance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;




class StaffController extends Controller
{
    //
    function dashboard(Request $request)  {

        $startDate = $request->from.' 00:00:00';
        $endDate = $request->to.' 23:59:59';
        $month = Carbon::now()->month;
        $today = Carbon::today();
        $year = Carbon::now()->year;

        
        $goods = Good::all();
        $total_funds= $goods->sum('good_cost'); 

        $funds = Good::selectRaw('SUM(good_cost) as amount')
                      ->whereMonth("created_at",$month)
                      ->whereYear("created_at",$year)
                      ->get();
 
        $totalFunds_this_month = $funds->first()->amount;
        
        $fundsToday = Good::selectRaw('SUM(good_cost) as amount')
                      ->whereDate("created_at",$today)
                      ->get();
        $totalfundsToday = $fundsToday->first()->amount;

        $usernumb= count(User::where("status", 1)->get());

        $inactiveusers = count(User::where("status", 0)->get());


        $texpenses = Expense::all();
        $total_expenses = $texpenses->sum('expenses_cost');

        $expenses = Expense::selectRaw('SUM(expenses_cost) as amount')
                      ->whereMonth("created_at",$month)
                      ->whereYear("created_at",$year)
                      ->get();
 
        $totalExpenses_this_month = $expenses->first()->amount;
        
        $expensesToday = Expense::selectRaw('SUM(expenses_cost) as amount')
                      ->whereDate("created_at",$today)
                      ->get();
        $totalExpensesToday = $expensesToday->first()->amount;

        $goodlist = DB::table('tbl_good')
                ->latest()
                ->limit(7)
                ->get();
                
        $data=$goodlist->pluck('good_cost');
        $labels = $goodlist->pluck('good_date_of_pickup');

        $stock = Stock::where('quantity', '>', 0)->count();

       $goodassignment = DB::table('stock_assign')
                    ->select(DB::raw('SUM(quantity) as quantity'))
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();

        
        $goodassignment_this_month = $goodassignment->first()->quantity;

        
        $undeliveredGoods = count(Good::whereNull('good_date_of_delivery')->get());

        $deliveredGoods = count(Good::whereNotNull('good_date_of_delivery')->get());

        $truckPerformance = TruckPerformance::all();

    return view('staff.dashboard', compact('total_funds','funds','totalFunds_this_month','totalfundsToday','usernumb',
    'total_expenses','totalExpenses_this_month','totalExpensesToday','inactiveusers','stock','undeliveredGoods','deliveredGoods','goodassignment_this_month','truckPerformance'));
         
    }


    public function Client_index(): View
    {
        //
        $clients = client::all();

        
       return view('staff.clients', compact('clients'));
        

    }

    public function Client_indexpdf()
    {
        # code...
        $clients = client::all();
       // return view('admin.clients.indexpdf', compact('clients'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.clients.indexpdf', compact('clients'));
      
        return $pdf->download('client_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Client_create()
    {
        //
        $count=count(client::all());
        $count++;
        //return $count;
        return view('staff.createclients')->with('count',$count);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Client_store(Request $request)
    {
        //
        $request->validate([
            
            'client_name' => 'required',
            'client_phone' => 'required',
            'client_address' => 'required|string',
    
            ]);

            $client= new client;
            $client->client_name= $request->input('title') ." ". $request->input('client_name');
            $client->client_phone = $request->input('client_phone');
            $client->client_address = $request->input('client_address');
            $client->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            clients::create($request->all()); */
    
            return redirect()->route('clients.index')
    
                    ->with('success','Client Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function Client_show(client $client)
    {
        //
        return view('clients.show',compact('client'));
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    // public function edit(client $client)
    // {
    //     //
    //     //return client;
    //     //return view('admin.editclient', compact('client'));
    //     return view('admin.editclient');

    // }

    public function Client_edit($client)
    {
        $client = client::find($client);
        //return $client;

        // return View::make('admin.editclient')
        //     ->with('client', $client);
        return view('staff.editclient', compact('client'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, client $client)
    // {
    //     //
    //     $request->validate([
    //         'title' => 'string',
    //         'client_name' => 'required',
    //         'client_phone' => 'required',
    //         'client_address' => 'required|string',
    //         ]);
    
    //         $client->update($request->all());
    
    //         return redirect()->route('admin-clients.index')->with('success','client information updated successfully');
     
    // }

    public function Client_update(Request $request,  $client)
    {
        //return $request;
        $rules = array(
           'title' => 'string',
            'client_name' => 'required',
            'client_phone' => 'required',
            'client_address' => 'required|string',
        );
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('Clients/edit/' . $client . '/')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            // store
            $client = client::find($client);
            $client->client_name       = $request->get('client_name');
            $client->client_phone      = $request->get('client_phone');
            $client->client_address= $request->get('client_address');
            $client->save();

            // redirect
            return redirect()->route('clients.index')->with('success','Client information updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function Client_destroy(client $client)
    {
        //
        $client->delete();



        return redirect()->route('clients.index')

                ->with('success','client Record deleted successfully');

    }
    public function clientGood($client)
    {
        # code...
        $driverall = client::find('$client')->firstOrFail()->myGood; 
        //$driverall = Drivers::find(1)->myTruck;
    }

    public function transactions( $id)
    {
     
        //$good= Good::find($id)->myPayments;// retriving amount paid for a good 
        $client= client::find($id);
        $trans= client::find($id)->myGood;

        $payments= client::find($id)->myPayments;

        //return $payments;
        $total_cost= $trans->sum('good_cost');
        //$numberToWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        //$numberTransformer = $numberToWords->getNumberTransformer('en');
        //$tcwords=$numberTransformer->toWords($total_cost);
        //$tcwords = SpellNumber::value($total_cost)->locale('es')->toLetters();
        
        
        //$tcwords="Cash";
        //dd($good);
       return view('staff.transaction',compact('trans','client'))->with('total_cost',$total_cost);
    }

    public function updateBulk(Request $request)
    {

        //return $request;
        $request->validate([
            'bulky_advance' => 'required',
            'client_id' => 'required',
            
            ]);

            if ($request->get('add')=='1') {
                # code...
                $client = client::find($request->get('client_id'));
                $client->bulky_advance = $client->bulky_advance + $request->get('bulky_advance');
                $client->save();
                return redirect()->route('clients.index')->with('success','client Bulky-Advance updated successfully');

            }
            
    }

    public function transactionspdf($id)
    {
          //$good= Good::find(2)->myPayments;// retriving amount paid for a good
        
        $client= client::find($id);
        $trans= client::find($id)->myGood;
        $total_cost= $trans->sum('good_cost');
        $numberToWords = new NumberToWords();
        // build a new number transformer using the RFC 3066 language identifier
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        //$tcwords=$numberTransformer->toWords($total_cost);
        $tcwords="yhbvvv";

        
         //return view('clients.pdftest',compact('trans','client','tcwords','total_cost'));

        
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        //$pdf = PDF::loadView('clients.pdftest',compact('trans','client','tcwords','total_cost'));
        $pdf = PDF::loadView('clients.transactionpdf',compact('trans','client','tcwords','total_cost'));
        return $pdf->download('client_transactions.pdf');

       
    }


    public function trucks_index()
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
        

        return view('staff.trucks', compact('trucks','ntrucks'));
    }

    public function trucks_indexpdf()
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
    public function trucks_create()
    {
        //
        $drivers = Drivers::all();
        return view('staff.createtrucks', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trucks_store(Request $request)
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
    
            return redirect()->route('trucks.index')
                    ->with('success','Truck added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
   // public function show(Truck $truck)
    public function trucks_show( $truck)
    {
        //
         # code...
 //     
        

        $truck = Truck::find($truck);
        return view('staff.show',compact('truck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function trucks_edit(string $id)
    {
        //
        $drivers = Drivers::all();
        $truck = Truck::find($id);
        //return $truck;
        return view('staff.trucksedit', ['truck' => $truck,'drivers' => $drivers]);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function trucks_update(Request $request, string $id)
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


    
            return redirect()->route('trucks.index', ['truck' => $truck])->with('success','Truck information updated successfully');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function trucks_destroy(Truck $truck)
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
        return view('staff.operations', compact('truck','total_cost','total_expenses','profit','total_amount_generated','truckValue','balance'))->with('goods',$TG);

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
  /**
     * Display a listing of the resource.
     */
    public function drivers_index()
    {
        // Paginate the joined drivers and trucks
        $adrivers = DB::table('tbl_drivers')
                      ->join('trucks', 'trucks.driver_id_no', 'tbl_drivers.driver_id_no')
                      ->get();
                    //  ->simplePaginate(5); // Change the number to the desired items per page
    
        // Get the driver IDs from the trucks table
        $tdrivers = DB::table('trucks')
                    ->whereNotNull('driver_id_no')
                    ->pluck('driver_id_no')
                    ->toArray();

        
        
        // Paginate the drivers not in the trucks table
        $drivers = DB::table('tbl_drivers')
                        ->whereNotIn('driver_id_no', $tdrivers)
                        
                        ->get();

        //return $drivers;       
                     //->simplePaginate(5); // Change the number to the desired items per page
    
        // Return the view with paginated data
        return view('staff.drivers', compact('adrivers', 'drivers'));
    }
    

    public function indexapdf()
    {
        # code...
       // $drivers = Drivers::all();
        $drivers= DB::table('tbl_drivers')
                        ->join('trucks','trucks.driver_id_no','tbl_drivers.driver_id_no')
                        ->get();
        
        //return $drivers;
       // return view('drivers.indexpdf', compact('drivers'));

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('drivers.indexapdf', compact('drivers'));
      
        return $pdf->download('drivers_list.pdf');

    }

    public function indexpdf()
    {
        # code...
        $tdrivers= DB::table('trucks')
                        ->pluck('driver_id_no');

        $drivers = DB::table('tbl_drivers')
                    ->whereNotIn('driver_id_no',$tdrivers )
                    ->get();
      
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('drivers.indexpdf', compact('drivers'));
      
        return $pdf->download('drivers_list.pdf');

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function drivers_create()
    {
        //
        $count=count(Drivers::all());
         $count++;
        $trucks = Truck::all();
       // $trucks = Truck::where('driver_id','STF-004');
        return view('staff.createdriver', compact('trucks','count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function drivers_store(Request $request)
    {
        //
        $request->validate([

            'driver_id_no' => 'required',
            'title' => 'string',
            'driver_name' => 'required',
            'driver_phone' => 'required',
            'driver_address' => 'required|string',
            'image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
  
    
            ]);

            $driver= new Drivers;
            $driver->driver_id_no= $request->input('driver_id_no');
            $driver->driver_name= $request->input('title') ." ". $request->input('driver_name');
            $driver->driver_phone = $request->input('driver_phone');
            $driver->driver_address = $request->input('driver_address');
            if ($request->has('image')) {
                // Get image file
                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = $request->input('driver_id_no'). '.' . $image->getClientOriginalExtension();
                // Define folder path
                $folder = 'Uploads/images/';
                $image->move( $folder,$name);
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name;//. '.' . $image->getClientOriginalExtension();
                
                // Set user profile image path in database to filePath
                $driver->driver_image = $filePath;
            }else{
                return $request;
                $driver->driver_image = " ";
            }
            $driver->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            Drivers::create($request->all()); */
    
            return redirect()->route('drivers.index')
    
                    ->with('success','Driver Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function drivers_show($driver)
    //public function show($driver)
    {
        $driver = Drivers::find($driver);
         $driverz = Drivers::where('driver_id',$driver->driver_id)->pluck('driver_id_no');
         $truck = Truck::where('driver_id_no',$driverz)->get();
         return view('staff.drivershow',compact('driver','truck'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function drivers_edit($driver)
    {
        //
         $driver_info = Drivers::find($driver);
         //
         $driver = DB::table('tbl_drivers')
                            ->leftJoin('trucks', 'tbl_drivers.driver_id_no', '=', 'trucks.driver_id_no')
                            ->select('tbl_drivers.*', 'trucks.driver_id_no as truck_driver_id_no')
                            ->where(function($query) use ($driver_info) {
                                $query->where('trucks.driver_id_no', $driver_info->driver_id_no)
                                    ->orWhereNull('trucks.driver_id_no');
                            })
                            ->first();
// Use first() instead of get() to get a single record
        //return $driver;
        $trucks = Truck::all();
       
       // return $driver;
       // $drivers = Drivers::findOrFail($drivers);
        return view('staff.editdriver',compact('driver','trucks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function drivers_update(Request $request, string $id)
    {
        //
        
        $driver= Drivers::find($id);
        //return $driver;
        $request->validate([
            'driver_id_no' => 'required',
            'title' => 'string',
            'driver_name' => 'required',
            'driver_phone' => 'required',
            'driver_address' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($request->has('image')) {
                // Get image file
                $image = $request->file('image');
                // Make a image name based on user name and current timestamp
                $name = $request->input('driver_id_no').'.'.$image->getClientOriginalExtension();
                // Define folder path
                $folder = 'Uploads/images/';
                $image->move( $folder,$name);
                // Make a file path where image will be stored [ folder path + file name + file extension]
                $filePath = $folder . $name; #. '.' . $image->getClientOriginalExtension();
                
                // Set user profile image path in database to filePath
                $driver->driver_image = $filePath;
            }else{
                //return $request;
               // $driver->driver_image = " ";
            }

                    $driver = Drivers::find($id);
                    $driver->driver_name       = $request->get('driver_name');
                    $driver->driver_phone      = $request->get('driver_phone');
                    $driver->driver_address= $request->get('driver_address');
                    $driver->save();
    
    
            return redirect()->route('drivers.index')->with('success','Driver information updated successfully');
     

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function drivers_destroy(Drivers $drivers)
    {
        //

        $drivers->delete();



        return redirect()->route('drivers.index')

                ->with('success','Driver Record deleted successfully');

 
    }

    public function driverTasks($driverx)
    {
        # code...
        $driver= Drivers::find($driverx);

        $gtasks= Drivers::find($driverx)->myTasks;
         $truck= Drivers::find($driverx)->myTruck;


          $tasks = $gtasks->where('status',0);
         $ctasks = $gtasks->where('status',1);
        //return $ctask;
     return view('staff.tasks',compact('tasks','driver','truck','ctasks'));
        //return view('clients.transaction',compact('trans','client'))->with('total_cost',$total_cost);
   
    }

    public function taskdetails($goodid)
    {
        # code...
        $good= Good::find($goodid);
        $driverid=$good->driver_id;
        $truckid=$good->truck_id;
        $truck=Truck::find($truckid);
        $clientid=$good->client_id;
        $client =client::find($clientid);
        $driver=Drivers::find($driverid);
        $expenses= Good::find($goodid)->myExpenses;
        $total_add_expenses=$expenses->sum('expenses_cost');
        $driverspercent =  ($good->good_cost - ( $total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission))*0.1;
     
          
    return view('staff.drivertaskdetails',compact('good','expenses','driver','client','driverspercent','truck'))->with('total_add_expenses',$total_add_expenses);
     
   

    }
    
    public function taskdetailspdf($goodid)
    {
        # code...
        
        $good= Good::find($goodid);
        $driverid=$good->driver_id;
        $truckid=$good->truck_id;
        $truck=Truck::find($truckid);
         $clientid=$good->client_id;
        $client =client::find($clientid);
        $driver=Drivers::find($driverid);
        $expenses= Good::find($goodid)->myExpenses;
        $total_add_expenses=$expenses->sum('expenses_cost');
        $driverspercent =  ($good->good_cost - ( $total_add_expenses + ($good->diesel_cost*$good->liters) + $good->road_expenses + $good->commission))*0.1;
         $header = public_path('images/invoiceheader.jpg');
          $driver_pic = public_path($driver->driver_image);
    
     
        
        //return view('drivers.taskdetailspdf',compact('good','expenses','driver','total_add_expenses','driverspercent','client','truck'));
   
      $pdf=PDF::loadView('admin.drivers.taskdetailspdf',compact('good','expenses','driver','total_add_expenses','driverspercent','client','truck','header','driver_pic'));  
        return $pdf->download('drivers.taskdetails.pdf');
        
    }

    public function taskcomplete($goodid)
    {
        # code...  onclick="return confirm('Are You Sure to Delete the Client Record?')"
      // $goodid= $request->good_id;
                $updateGood = DB::table('tbl_good')
                                        ->where('good_id', $goodid)
                                        ->update(['status' => 1]);
        return redirect()->back()->with('success','Record updated successfully');
        

    }



    public function goods_index()
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
        return view('staff.goods', compact('goods','dgoods'));

    }

    public function goods_indexpdf()
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
     public function goods_indexdpdf()
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
    public function goods_create()
    {
        //
        $trucks = Truck::all();
        $clients = client::all();
        $goodsTypes=GoodsType::orderBy('goods_type','ASC')->get();
        // $companies=FuelDebt::all()->unique('company');

        $count=count(Good::all())+1;
         $count++;

          $pcount=count(Payment::all());
         $pcount++;

        return view('staff.creategoods', compact('trucks','clients','count','goodsTypes','pcount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function goods_store(Request $request)
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
    
            return redirect()->route('goods.index')
    
                    ->with('success','Good Added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function goods_show($good)
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

        return view('staff.showgoods',compact('good'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function goods_edit(string $good)
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
    
        return view('staff.editgoods',compact('good','trucks','clients','driver_name','aclients','payment'))->with('selected',$selected);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function goods_update(Request $request, string $id)
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





    
            return redirect()->route('goods.index')->with('success','Good information updated successfully');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Good  $good
     * @return \Illuminate\Http\Response
     */
    public function goods_destroy(Good $good)
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
    
    return redirect()->route('goods.index')
                    ->with('success','Good Delivery Record updated successfully');

}




public function payments_index()
    {
        //

 
       //$payments = Payment::all();
        $dpayments=DB::table('tbl_payment')
                     ->join('tbl_clients','tbl_clients.id','tbl_payment.client_id')
                     ->join('tbl_good','tbl_good.good_id','tbl_payment.good_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->where('tbl_payment.payment_status',0)
                     ->latest('tbl_payment.created_at')
                     ->get();
        $payments=DB::table('tbl_payment')
                     ->join('tbl_clients','tbl_clients.id','tbl_payment.client_id')
                     ->join('tbl_good','tbl_good.good_id','tbl_payment.good_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->where('tbl_payment.payment_status',1)
                     ->latest('tbl_payment.created_at')
                     ->get();
        //return $payments;
        return view('staff.payments', compact('payments','dpayments')); 
    }

    public function payments_indexcpdf()
    {
        # code...
         $payments=DB::table('tbl_payment')
                     ->join('tbl_clients','tbl_clients.id','tbl_payment.client_id')
                     ->join('tbl_good','tbl_good.good_id','tbl_payment.good_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->where('tbl_payment.payment_status',1)
                     ->latest('tbl_payment.created_at')
                     ->get();
        //return $payments;
         PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
          $pdf = PDF::loadView('admin.payments.indexcpdf', compact('payments')); 

        return $pdf->download('Completed_Payment_list.pdf');

    }

    public function payments_indexpdf()
    {
        # code...
          $dpayments=DB::table('tbl_payment')
                     ->join('tbl_clients','tbl_clients.id','tbl_payment.client_id')
                     ->join('tbl_good','tbl_good.good_id','tbl_payment.good_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->where('tbl_payment.payment_status',0)
                     ->latest('tbl_payment.created_at')
                     ->get();
        //return $dpayments;
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.payments.indexpdf', compact('dpayments')); 
        return $pdf->download('UnCompleted_Payment_list.pdf');
   }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments_create()
    {
        //
         /* $good=DB::table('tbl_good')
        ->where('good_id_no','G001')
        ->get();
return $good[0]->good_cost;  */

         $goods = Good::where('payment_status','0')->get();
        // return $goods;
      $clients = client::all();
         $count=count(Payment::all());
         $count++;
        return view('payments.create', compact('goods','count','clients'));
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payments_store(Request $request)
    {
        //
        $request->validate([

            'payment_id_no' => 'required',
            'good_id' => 'required|string',
            
            'payment_mode' => 'required|string',
            'client_id' => 'required|string',
            //'payment_deposit' => 'required',
            
            
    
            ]);
            $payment_id_no=$request->input('payment_id_no');
            $payment= new Payment;
            $payment->payment_id_no= $request->input('payment_id_no');
            $payment->payment_mode= $request->input('payment_mode');
            $payment->good_id= $request->input('good_id');
            $gid=$request->input('good_id');
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

    
            payments::create($request->all()); */
    
            return redirect()->route('payments.index')
    
                    ->with('success','Payment Added successfully.');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function payments_show(Payment $payment)
    {
        //
        return view('payments.show',compact('payment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function payments_edit($payment)
    {
        //Payment
         $payment=Payment::find($payment);
        // return $payment;
        return view('staff.editpayments',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function payments_update(Request $request,  $payment)
    {
        //
        $request->validate([
            'payment_id_no' => 'required',
            'payment_id'=> 'required',
            'good_id'=> 'required',
            'payment_deposit' => 'required',
            ]);
            $payment_id=$request->input('payment_id');
            $gid=$request->input('good_id');
            $add_deposit=$request->input('payment_deposit');
            
            
$updatepay = DB::table('tbl_payment')
            ->where('payment_id', $payment_id)
            ->increment('payment_deposit', $add_deposit);
            //->update(['payment_deposit' , 'tbl_payment.payment_deposit'+$add_deposit]);

   
            $goodinfo= Good::find($gid);
            $goodCost=$goodinfo->good_cost;

           
            $payinfo= Payment::find($payment_id);
            $gooddeposit=$payinfo->payment_deposit;

            if ($gooddeposit >= $goodCost) {
                # code...
                $updateGood = DB::table('tbl_good')
                        ->where('good_id', $gid)
                        ->update(['payment_status' => 1]);
                $updatepay = DB::table('tbl_payment')
                        ->where('payment_id', $payment_id)
                        ->update(['payment_status' => 1]);
            }
           // $payment->update($request->all());
    
            return redirect()->route('payments.index')->with('success','Payment information updated successfully');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function payments_destroy(Payment $payment)
    {
        //
        $payment->delete();



        return redirect()->route('payments.index')

                ->with('success','payment Record deleted successfully');

    }

    public function fetchGood(Request $request)     
    {
        # code...
         
        $good_id=$request['good_id'];
       // return $good_id;
    /*     $good=DB::table('tbl_good')
                    ->where('good_id_no','=',$good_id)->get();
         */
         // $good = Good::where('good_id_no',$good_id)->firstOrFail();
          //$good = Good::find($good_id)->firstOrFail();
      /*   $good = DB::table('tbl_good')
                    ->join('tbl_clients', 'tbl_clients.id','tbl_good.client_id')
                    ->where('tbl_good.good_id',$good_id)
                    ->get();
          //dd($good); 

          return $good; */

        //$output= $good->good_cost;
        //$output1= number_format($output,2);

       /*  $good=DB::table('tbl_good')
        ->where('good_id_no','G001')
        ->get();
return $good; */
       // $output='<input type="text" value="{{$good->good_cost}}">';
       // $output= $good->good_cost;



    /*    <div class="form-group col-md-4">

       <label for="good_cost" class="font-weight-bold">Good Cost:</label>
       <input type="text" class="form-control" name="good_cost" id="good_cost"  readonly/>
   </div>
   <div class="form-group col-md-4">

     <label for="client" class="font-weight-bold">Client :</label>
     <input type="text" class="form-control" name="client_id" id="client_id"  readonly/>
 </div>
 */
   
        //echo '₦' . $output1;
        //echo  $output;
      // echo "1111";


      
      $good = Good::where('good_id',$good_id)->firstOrFail();
      //dd($good); 
      $good_cost= '₦' .number_format($good->good_cost,2);
      $clientid= $good->client_id;
      $client = client::where('id',$clientid)->firstOrFail();
      $client_name=$client->client_name;
      //echo $client_name;
      $output= '<div class="form-group col-md-4"><label for="good_cost" class="font-weight-bold">Good Cost:</label>
      <input type="text" class="form-control" name="good_cost" value="'.$good_cost .'" id="good_cost"  readonly/></div>
      <input type="hidden" class="form-control" value="'. $clientid .'" name="client_id" id="client_id"  readonly/>
      <div class="form-group col-md-4">
      <label for="Client_name" class="font-weight-bold">Client Name:</label>
      <input type="text" class="form-control" name="client_name" value="'.$client_name .'" id="client_name"  readonly/>
      </div>
     ';
     echo $output;


    }






    public function expenses_index()
    {
        //
        $dexpenses =  Expense::all();
        $dexpenses=DB::table('expenses')
                    ->join('tbl_good','tbl_good.good_id','expenses.good_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->latest('expenses.created_at')
                     ->get();
        return view('staff.expenses', compact('dexpenses'));
       

    }
    public function expenses_indexpdf()
    {
        # code...
         $dexpenses =  Expense::all();
       //  return $dexpenses;
        $dexpenses=DB::table('expenses')
                    ->join('tbl_good','tbl_good.good_id','expenses.good_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->latest('expenses.created_at')
                     ->get();
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.expenses.indexpdf', compact('dexpenses'));
       // return view('admin.expenses.indexpdf', compact('dexpenses'));
        return $pdf->download('Expenses_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expenses_create()
    {
        //
        //$goods = Good::all();
        $goods=DB::table('tbl_good')
                     ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_good.driver_id','tbl_drivers.driver_id')
                     ->whereNull('tbl_good.good_date_of_delivery')
                     ->get();
       // return  $goods;
        return view('staff.createexpenses', compact('goods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function expenses_store(Request $request)
    {
        //
        $request->validate([

            'good_id' => 'required',
            'expenses_cost' => 'required',
            'expenses_reason' => 'required',
            'expenses_date' => 'required',
            
            ]);

            $expenses= new Expense;
            $expenses->good_id= $request->input('good_id');
            $expenses->expenses_cost=  $request->input('expenses_cost');
            $expenses->expenses_reason=  $request->input('expenses_reason');
            $expenses->expenses_date=  $request->input('expenses_date');
            $expenses->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            goods::create($request->all()); */
    
            return redirect()->route('expenses.index')
    
                    ->with('success','Expenses Record Added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function expenses_show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function expenses_edit(Expense $expense)
    {
        //
        return view('staff.editexpenses',compact('expense'));

    }
    
     //changed on 28/5/2021
     public function edit2($expenseid)
    {
        //
        
        //updated on 28/5/2021
        $expense=DB::table('tbl_good')
                     ->join('expenses','expenses.good_id','tbl_good.good_id')
                     ->where('expenses.expenses_id',$expenseid)
                     ->get();
    return  $expense;
    //return view('expenses.edit',compact('expense'));

    }
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function expenses_update(Request $request, Expense $expense)
    {
        //
        $request->validate([
            'good_id' => 'required',
            'expenses_cost' => 'required',
            'expenses_reason' => 'required',
            'expenses_date' => 'required',
            ]);
    
            $expense->update($request->all());
    
            return redirect()->route('expenses.index')->with('success','Expenses information updated successfully');
     
    }

 






    public function fuelDebt_index()
    {
        //
   
     $companies= DB::table('filling_stations')
                            ->get();
   
      
         return view('staff.cfuelDebt', compact('companies'));
      
    }

    public function cdebt($cid)
    {
        //
             $company= DB::table('filling_stations')
                                ->where('company_id',$cid)
                                ->get();
             $payments= DB::table('fuel_debt_payment')
                                ->where('company_id',$cid)
                                ->get();
        
                                
           $debts=DB::table('fuel_debts')
                     ->join('trucks','trucks.id','fuel_debts.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id_no','trucks.driver_id_no')
                     ->latest('fuel_debts.created_at')
                     ->where('fuel_debts.company',$cid)
                     ->get();

      /*  $debts_cost= $debts->pluck('diesel_cost','liters');
        $total_debt= $debts_cost->sum('diesel_cost'*'liters');
        */

         $total_debt = DB::table('fuel_debts')
                                ->select(DB::raw('sum(diesel_cost*liters) AS total_debt'))
                                ->where('fuel_debts.company',$cid)
                                ->get();
        $total_pay = DB::table('fuel_debt_payment')
                                ->select(DB::raw('sum(amount_paid) AS total_pay'))
                                ->where('fuel_debt_payment.company_id',$cid)
                                ->get();
       //return $total_pay;
        /*$pdebts=DB::table('fuel_debts')
                     ->join('trucks','trucks.id','fuel_debts.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id_no','trucks.driver_id_no')
                      ->whereNotNull('fuel_debts.payment_date')
                     ->latest('fuel_debts.created_at')
                     ->where('fuel_debts.company',$cid)
                     ->get();*/
        //return $debts;
       // $debts=FuelDebt::all();
         return view('staff.fuelDebt', compact('debts','company','total_debt','payments','total_pay'));
      
    }

     public function fuelDebt_indexpdf($cid)
    {
        # code...
            $payments= DB::table('fuel_debt_payment')
                                ->where('company_id',$cid)
                                ->get();
        $company=DB::table('filling_stations')
                     ->where('filling_stations.company_id',$cid)
                     ->get();
         $total_pay = DB::table('fuel_debt_payment')
                                ->select(DB::raw('sum(amount_paid) AS total_pay'))
                                ->where('fuel_debt_payment.company_id',$cid)
                                ->get();
        //return view('fuelDebt.indexpdf', compact('payments','company'));
      
       
       PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.fuelDebt.indexpdf', compact('payments','company','total_pay'));
        
       return $pdf->download('fuel_debt_list.pdf');

    }

    public function fuelDebt_indexppdf($cid)
    {
        # code...
        //greturn $cid;
           $pdebts=DB::table('fuel_debts')
                    ->join('filling_stations','filling_stations.company_id','fuel_debts.company')
                     ->join('trucks','trucks.id','fuel_debts.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id_no','trucks.driver_id_no')
                     ->latest('fuel_debts.created_at')
                     ->where('fuel_debts.company',$cid)
                     ->get();
         $company=DB::table('filling_stations')
                     ->where('filling_stations.company_id',$cid)
                     ->get();
          $total_debt = DB::table('fuel_debts')
                                ->select(DB::raw('sum(diesel_cost*liters) AS total_debt'))
                                ->where('fuel_debts.company',$cid)
                                ->get();
        /* $pdebts=DB::table('fuel_debts')
                     ->join('trucks','trucks.id','fuel_debts.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id_no','trucks.driver_id_no')
                      ->whereNotNull('fuel_debts.payment_date')
                     ->latest('fuel_debts.created_at')
                     ->get();*/
        //return            $company;
       // return view('fuelDebt.indexppdf', compact('pdebts','company','total_debt'));
      
       
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.fuelDebt.indexppdf', compact('pdebts','company','total_debt'));
        
        return $pdf->download('fuel_debt_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fuelDebt_create()
    {
        //
        $companies=filling_station::all();
         $count=count(FuelDebt::all());
         $count++;
        $trucks = Truck::all();
         return view('staff.createfuelDebt', compact('trucks','count','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fuelDebt_store(Request $request)
    {
        //
         $request->validate([

            'truck_id' => 'required',
            'company' => 'required',
            'diesel_cost' => 'required',
            'liters' => 'required',
            'debt_date' => 'required',
            
            ]);

            $debt= new FuelDebt;
            $debt->truck_id = $request->input('truck_id');
            
            $debt->diesel_cost=  $request->input('diesel_cost');
            $debt->liters=  $request->input('liters');
            $debt->debt_date =  $request->input('debt_date');
            $debtcompany=  $request->input('company');
             if ($debtcompany=='Others') {
                # code...
                $filling_station= new filling_station;
                $filling_station->company_name=   $request->input('ocompany');
                $filling_station->balance=   ($request->input('diesel_cost') * $request->input('liters'));
                $filling_station->save();
                $debt->company= $filling_station->company_id;
            }else{
                $debt->company=  $request->input('company');
                $fs=  $request->input('company');
                $filling_station= filling_station::find($fs);

                $filling_station->balance= $filling_station->balance +  ($request->input('diesel_cost') * $request->input('liters'));
                $filling_station->save();
            }

            $debt->save();
            /* return redirect('/posts')->with('success', 'Post Created');

    
            goods::create($request->all()); */
    
            return redirect()->route('fuelDebts.index')
    
                    ->with('success','Debt Record Added successfully.');

    }

public function payment($id)
{
    # code...
    $filling_station=filling_station::find($id);
return view('staff.fuel_debt_payment',compact('filling_station'));


}

public function store_payment(Request $request)
{
     $request->validate([

            'balance' => 'integer|required',
            'payment_method' => 'required',
            'payer' => 'required',
            'amount_paid' => 'integer|required',
            'payment_date' => 'required',
            
            ]);

         $balance = $request->input('balance');
          $company_id = $request->input('company_id');
            
            $payment_method=  $request->input('payment_method');
            $payer=  $request->input('payer');
            $amount_paid =  $request->input('amount_paid');
            $payment_date=  $request->input('payment_date');
            $balance_after_payment= $balance - $amount_paid;
          $insert=  DB::insert('insert into fuel_debt_payment (payment_method,company_id, payer, amount_paid, balance_before_payment, balance_after_payment,payment_date) values (?,?, ?,?,?,?, ?)', [$payment_method,$company_id,$payer,$amount_paid,$balance, $balance_after_payment, $payment_date]);

          if ($insert) {
 
              # code...

            $balance_update = DB::update('update filling_stations set balance = ? where company_id = ?', [$balance_after_payment,$company_id]);
              return redirect()->route('fuelDebts.cdebt',$company_id)->with('success','Fuel Debt Payment updated successfully');
          }else{
            return redirect()->route('fuelDebts.index')->with('Error','Fuel Debt Payment update Fail');

}
  




}
    /**
     * Display the specified resource.
     *
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function fuelDebt_show(FuelDebt $fuelDebt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function fuelDebt_edit(FuelDebt $fuelDebt)
    {
        //
               $selected = "";

        $truck_id =$fuelDebt->truck_id;
         $xtruck=Truck::find($truck_id);
        $driver_id_no=$xtruck->driver_id_no;
         $driver=  Drivers::where('driver_id_no',$driver_id_no)->get();
       //return $driver;
          $trucks=Truck::all();
     
       $driver_name=$driver[0]->driver_name;
           
        
    
        return view('fuelDebt.edit',compact('fuelDebt','trucks','xtruck','driver_name'))->with('selected',$selected);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function fuelDebt_update(Request $request, FuelDebt $fuelDebt)
    {
        //
                //
        $request->validate([
            'truck_id' => 'required',
            'company' => 'required',
            'diesel_cost' => 'required',
            'liters' => 'required',
            'debt_date' => 'required',
           
            ]);
    
            $fuelDebt->update($request->all());
    
            return redirect()->route('admin-fuelDebt.index')->with('success','Fuel Debt information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelDebt $fuelDebt)
    {
        //
    }

    public function debtpaid($fdid)
    {
        # code...
        $date= Date('Y-m-d');
     $updateGood = DB::table('fuel_debts')
                ->where('fdid', $fdid)
                ->update(['payment_date' => $date ]); 
    
    return redirect()->route('admin-fuelDebt.index')
                    ->with('success','Payment Record updated successfully');
    }


    public function stocks_index()
    {
        //
        $dexpenses =  Stock::all();
        $stocks=DB::table('stock')
                    ->join('stock_types','stock_types.id','stock.type_id')
                    ->select(
                        'stock.id as stock_id', 
                        'stock_types.id as stock_type_id', 
                        'stock.stock', 
                        'stock.quantity', 
                        'stock.unit_price', 
                        'stock.description', 
                        'stock_types.type'
                    )
                     ->get();

        $assgnedstocks=DB::table('stock_assign')
                     ->join('stock','stock.id','stock_assign.stock_id')
                     ->join('stock_types','stock_types.id','stock.type_id')
                     ->join('tbl_good','tbl_good.good_id','stock_assign.good_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->select(
                         'stock.id as stock_id', 
                         'stock_types.id as stock_type_id', 
                         'stock.stock', 
                         'stock_assign.assign_id',
                         'stock_assign.quantity', 
                         'stock.unit_price', 
                         'stock.description', 
                         'stock_types.type',
                         'stock_assign.date',
                         'tbl_good.good_type',
                         'trucks.truck_model',
                         'trucks.plate_number',
                         'tbl_drivers.driver_name',
                     )
                      ->get();

                  
        //return $assgnedstocks;
        return view('staff.stocks', compact('stocks','assgnedstocks'));
    }

    public function stocks_assignPDF()
    {
      

        # code...
        $assgnedstocks=DB::table('stock_assign')
                     ->join('stock','stock.id','stock_assign.stock_id')
                     ->join('stock_types','stock_types.id','stock.type_id')
                     ->join('tbl_good','tbl_good.good_id','stock_assign.good_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->select(
                         'stock.id as stock_id', 
                         'stock_types.id as stock_type_id', 
                         'stock.stock', 
                         'stock_assign.assign_id',
                         'stock_assign.quantity', 
                         'stock.unit_price', 
                         'stock.description', 
                         'stock_types.type',
                         'stock_assign.date',
                         'tbl_good.good_type',
                         'trucks.truck_model',
                         'trucks.plate_number',
                         'tbl_drivers.driver_name',
                     )
                     ->orderBy('stock_assign.date', 'desc')
                    ->get();
        //return view('admin.stock_assign', compact('assgnedstocks'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.expenses.stock_assign', compact('assgnedstocks'));
        return $pdf->download('StockAssignment.pdf');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function stocks_create()
    {
        //
        $stock_types=DB::table('stock_types')
                    ->get();

            return view('staff.createstock', compact('stock_types'));
       
    }

    public function stocktypecreate() {
        
        $stock_types=DB::table('stock_types')
        ->get();

    return view('staff.stocktypecreate', compact('stock_types'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function stocks_store(Request $request)
    {
        //
                //
                $request->validate([

                    'stock' => 'required',
                    'stock_type' => 'required',
                    'quantity' => 'required',
                    'description' => 'required',
                    'price' => 'required',

                    
                    ]);
        
                    $stock= new Stock;
                    $stock->stock= $request->input('stock');
                    $stock->unit_price= $request->input('price');
                    $stock->type_id=  $request->input('stock_type');
                    $stock->quantity=  $request->input('quantity');
                    $stock->description=  $request->input('description');
                    $stock->save();
                    /* return redirect('/posts')->with('success', 'Post Created');
        
            
                    goods::create($request->all()); */
            
                    return redirect()->route('stock.index')
            
                            ->with('success','Stock Record Added successfully.');
    }

    

    /**
     * Store a newly created resource in storage.
     */

    public function storetype(Request $request)
    {
        // Validate the request data
        $request->validate([
            'stock_type' => 'required',
            'description' => 'required',
        ]);

        // Insert the data into the stock_types table
        DB::table('stock_types')->insert([
            'type' => $request->input('stock_type'),
            'description' => $request->input('description'),
            'created_at' => now(),
            
        ]);

        // Return a response or redirect
        return redirect()->back()->with('success', 'Stock type added successfully!');
        
    }

    /**
     * Display the specified resource.
     */
    public function stocks_show(string $id)
    {
        //
    }

     /**
     * Show the form for editing the specified resource.
     */
    public function assignGood(string $id)
    {
        
        $stocks = DB::table('stock')
            ->join('stock_types', 'stock_types.id', '=', 'stock.type_id')
            ->select(
                'stock.id as stock_id', 
                'stock_types.id as stock_type_id', 
                'stock.stock', 
                'stock.quantity', 
                'stock.unit_price', 
                'stock.description', 
                'stock_types.type'
            )
            ->where ('stock.id', $id)
            ->get()
            ->toArray();

            
    
     $goods=DB::table('tbl_good')
            ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
            ->join('trucks','trucks.id','tbl_good.truck_id')
            ->join('tbl_drivers','tbl_good.driver_id','tbl_drivers.driver_id')
            ->whereNull('tbl_good.good_date_of_delivery')
            ->get();

        return view('staff.goodstockassign', ['stocks' => $stocks, 'goods' => $goods]);
    }
    




    public function assign(Request $request, string $id)
    {
        //return $request;
        $validated = $request->validate([
            'stock_id' => 'required',
            'good_id' => 'required|exists:tbl_good,good_id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        // Fetch the stock record
        $stock = DB::table('stock')->where('id', $id)->first();
       
        if (!$stock) {
            return redirect()->back()->withErrors(['stock' => 'Stock not found.']);
        }

        
    
        // Check if sufficient stock is available
        if ($validated['quantity'] > $stock->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }
    
        // Deduct the assigned quantity from the stock
        DB::table('stock')
            ->where('id', $id)
            ->update([
                'quantity' => $stock->quantity - $validated['quantity'],
            ]);
    
        // Insert the assignment into the `stock_assign` table
        DB::table('stock_assign')->insert([
            'stock_id' => $id,
            'good_id' => $validated['good_id'],
            'quantity' => $validated['quantity'],
            'date' => now(),
        ]);
        
        $unit_price = $stock->unit_price;
        $cost = $unit_price * $validated['quantity'];

         $expenses= new Expense;
         $expenses->good_id= $validated['good_id'];
         $expenses->expenses_cost=  $cost;
         $expenses->expenses_reason=  $validated['quantity'] .' '.$stock->stock . ' at '. $unit_price. ' on '. now() ;
         $expenses->expenses_date=  now();
         $expenses->save();
    
        return redirect()->route('stock.index')->with('success', 'Stock successfully assigned to goods!');
    }


    public function assignGoodEdit(string $id)
    {
        
        $assgnedstocks=DB::table('stock_assign')
                    ->join('stock','stock.id','stock_assign.stock_id')
                    ->join('stock_types','stock_types.id','stock.type_id')
                    ->select(
                        'stock.id as stock_id', 
                        'stock_types.id as stock_type_id', 
                        'stock.stock', 
                        'stock_assign.quantity', 
                        'stock.unit_price', 
                        'stock.description', 
                        'stock_types.type'
                    )
                    ->where ('stock_assign.assign_id', $id)
                    ->get()
                    ->first();

                    return $assgnedstocks;

            
    
     $goods=DB::table('tbl_good')
            ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
            ->join('trucks','trucks.id','tbl_good.truck_id')
            ->join('tbl_drivers','tbl_good.driver_id','tbl_drivers.driver_id')
            ->whereNull('tbl_good.good_date_of_delivery')
            ->get();
        

        return view('staff.goodstockassign', ['stocks' => $stocks, 'goods' => $goods]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function stocks_edit(string $id)
    {
        //
        $stock = Stock::find($id);
        $goods=DB::table('tbl_good')
                ->join('tbl_clients','tbl_clients.id','tbl_good.client_id')
                ->join('trucks','trucks.id','tbl_good.truck_id')
                ->join('tbl_drivers','tbl_good.driver_id','tbl_drivers.driver_id')
                ->whereNull('tbl_good.good_date_of_delivery')
                ->get();
        //return $truck;
        return view('staff.stockedit', ['stock' => $stock,'goods' => $goods]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function stocks_update(Request $request, string $id)
    {
       // return $request;
        // Validate the input data
        $validated = $request->validate([
            'stock' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);
    
        // Find the stock item by ID
        $stock = Stock::findOrFail($id);
    
        // Update the stock item with the validated data
        $stock->update([
            'stock' => $validated['stock'],
            'unit_price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
        ]);
    
        // Redirect back with a success message
        return redirect()->route('stock.index')->with('success', 'Stock updated successfully!');
    }
    
    


}

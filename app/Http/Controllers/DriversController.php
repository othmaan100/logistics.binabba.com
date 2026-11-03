<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Drivers;
use App\Models\Good;
use App\Models\Truck;
use App\Models\client;
use PDF;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginate the joined drivers and trucks
        $adrivers = DB::table('tbl_drivers')
                      ->join('trucks', 'trucks.driver_id_no', 'tbl_drivers.driver_id_no')
                      ->get();
                    //  ->simplePaginate(5); // Change the number to the desired items per page
    
        // Get the driver IDs from the trucks table
        $tdrivers = DB::table('trucks')
                      ->pluck('driver_id_no')
                      ->toArray();
        
        
        // Paginate the drivers not in the trucks table
        $drivers = DB::table('tbl_drivers')
                        ->whereNotIn('driver_id_no', $tdrivers)
                        ->get();

        //return $drivers;       
                     //->simplePaginate(5); // Change the number to the desired items per page
    
        // Return the view with paginated data
        return view('admin.drivers', compact('adrivers', 'drivers'));
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
    public function create()
    {
        //
        $count=count(Drivers::all());
         $count++;
        $trucks = Truck::all();
       // $trucks = Truck::where('driver_id','STF-004');
        return view('admin.createdriver', compact('trucks','count'));
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
    
            return redirect()->route('admin-drivers.index')
    
                    ->with('success','Driver Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function show(string $driver)
    //public function show($driver)
    {
        $driver = Drivers::find($driver);
         $driverz = Drivers::where('driver_id',$driver->driver_id)->pluck('driver_id_no');
         $truck = Truck::where('driver_id_no',$driverz)->get();
         return view('admin.drivershow',compact('driver','truck'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function edit(string $driver_id)
    {
        //
         $driver_info = Drivers::find($driver_id);
         $driver = DB::table('tbl_drivers') 
                    ->join('trucks', 'trucks.driver_id_no', 'tbl_drivers.driver_id_no') 
                    ->where('trucks.driver_id_no', $driver_info->driver_id_no) 
                    ->first(); // Use first() instead of get() to get a single record
        $trucks = Truck::all();
       
       // return $driver;
       // $drivers = Drivers::findOrFail($drivers);
        return view('admin.editdriver',compact('driver','trucks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, string $id)
{
    $driver = Drivers::find($id);
    
    $request->validate([
        'driver_id_no' => 'required',
        'title' => 'string',
        'driver_name' => 'required',
        'driver_phone' => 'required',
        'driver_address' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    if ($request->hasFile('image')) {
        // Get image file
        $image = $request->file('image');
        // Make a image name based on user name and current timestamp
        $name = $request->input('driver_id_no').'.'.$image->getClientOriginalExtension();
        // Define folder path
        $folder = 'Uploads/images/';
        $image->move($folder, $name);
        // Make a file path where image will be stored
        $filePath = $folder . $name;
        
        // Set user profile image path in database to filePath
        $driver->driver_image = $filePath;
    }
    
    // Update other fields (REMOVED the second Drivers::find($id) here)
    $driver->driver_name = $request->get('driver_name');
    $driver->driver_phone = $request->get('driver_phone');
    $driver->driver_address = $request->get('driver_address');
    $driver->save();

    return redirect()->route('admin-drivers.index')->with('success','Driver information updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drivers $drivers)
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
     return view('admin.tasks',compact('tasks','driver','truck','ctasks'));
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
     
          
    return view('admin.drivertaskdetails',compact('good','expenses','driver','client','driverspercent','truck'))->with('total_add_expenses',$total_add_expenses);
     
   

    }
    
   public function taskdetailspdf($goodid)
{
    $good = Good::find($goodid);
    $driverid = $good->driver_id;
    $truckid = $good->truck_id;
    $truck = Truck::find($truckid); 
    $clientid = $good->client_id;
    $client = Client::find($clientid);
    $driver = Drivers::find($driverid);
    $expenses = Good::find($goodid)->myExpenses;
    $total_add_expenses = $expenses->sum('expenses_cost');
    $driverspercent = ($good->good_cost - ($total_add_expenses + ($good->diesel_cost * $good->liters) + $good->road_expenses + $good->commission)) * 0.1;
    
    // Convert images to base64 data URLs
    $driver_pic_path = public_path($driver->driver_image);
    $header_path = public_path('images/invoiceheader.jpg');
    
    // Check if driver image exists and convert to base64
    if (file_exists($driver_pic_path)) {
        $driver_pic_type = pathinfo($driver_pic_path, PATHINFO_EXTENSION);
        $driver_pic_data = base64_encode(file_get_contents($driver_pic_path));
        $driver_pic = 'data:image/' . $driver_pic_type . ';base64,' . $driver_pic_data;
    } else {
        $driver_pic = ''; // or use a default placeholder image
    }
    
    // Convert header image to base64
    if (file_exists($header_path)) {
        $header_type = pathinfo($header_path, PATHINFO_EXTENSION);
        $header_data = base64_encode(file_get_contents($header_path));
        $header = 'data:image/' . $header_type . ';base64,' . $header_data;
    } else {
        $header = '';
    }
    
    $pdf = PDF::loadView('admin.drivers.taskdetailspdf', compact('good', 'expenses', 'driver', 'total_add_expenses', 'driverspercent', 'client', 'truck', 'driver_pic', 'header'));  
    return $pdf->download('drivers.taskdetailspdf.pdf');
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use PDF;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        return view('admin.stocks', compact('stocks','assgnedstocks'));
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
                      ->get();
        //return view('admin.stock_assign', compact('assgnedstocks'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('admin.expenses.stock_assign', compact('assgnedstocks'));
        return $pdf->download('StockAssignment.pdf');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $stock_types=DB::table('stock_types')
                    ->get();

            return view('admin.createstock', compact('stock_types'));
       
    }

    public function stocktypecreate() {
        
        $stock_types=DB::table('stock_types')
        ->get();

    return view('admin.stocktypecreate', compact('stock_types'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            
                    return redirect()->route('admin-stocks.index')
            
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
    public function show(string $id)
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

        return view('admin.goodstockassign', ['stocks' => $stocks, 'goods' => $goods]);
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
    
        return redirect()->route('admin-stocks.index')->with('success', 'Stock successfully assigned to goods!');
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
        

        return view('admin.goodstockassign', ['stocks' => $stocks, 'goods' => $goods]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        return view('admin.stockedit', ['stock' => $stock,'goods' => $goods]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
        return redirect()->route('admin-stocks.index')->with('success', 'Stock updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

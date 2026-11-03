<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use PDF;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dexpenses =  Expense::all();
        $dexpenses=DB::table('expenses')
                    ->join('tbl_good','tbl_good.good_id','expenses.good_id')
                     ->join('trucks','trucks.id','tbl_good.truck_id')
                     ->join('tbl_drivers','tbl_drivers.driver_id','tbl_good.driver_id')
                     ->latest('expenses.created_at')
                     ->get();
        return view('admin.expenses', compact('dexpenses'));
       

    }
    public function indexpdf()
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
        return $pdf->download('Expenses_list.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        return view('admin.createexpenses', compact('goods'));
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
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
        return view('expenses.edit',compact('expense'));

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
    public function update(Request $request, Expense $expense)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}

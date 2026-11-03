<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FuelDebt;
use App\Models\filling_station;
use App\Models\Truck;
use PDF;

class FuelDebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
      /* $companies= DB::table('filling_stations')
                        ->join('fuel_debt_payment','fuel_debt_payment.company_id','filling_stations.company_id')
                       // ->join('fuel_debts','fuel_debts.company','filling_stations.company_id')
                       // ->select('filling_stations.company_id','filling_stations.company_name',DB::raw('sum(fuel_debt_payment.amount_paid) AS total_pay'), DB::raw('sum(fuel_debts.diesel_cost*liters) AS total_debt'))
                         ->select('filling_stations.company_name',DB::raw('sum(fuel_debt_payment.amount_paid) AS total_pay'))
                         ->groupBy('filling_stations.company_name')
                        ->get();
         $companies= filling_station::select("filling_stations.*")
                ->join('fuel_debt_payment','fuel_debt_payment.company_id','filling_stations.company_id')
                ->orderByRaw("SUM(fuel_debt_payment.amount_paid) desc")
                ->groupBy("filling_stations.company_id")
                ->get();
                
       Book::select("books.*")
                ->join("book_reviews br","br.book_id","=","books.id")
                ->orderByRaw("AVG(br.overall_point) desc")
                ->groupBy("books.id")
                ->take(10) # or how many book you want
                ->get();*/
    
       // return $companies;
     $companies= DB::table('filling_stations')
                            ->get();
     /* $total_pay = DB::table('fuel_debt_payment')
                                ->select(DB::raw('sum(amount_paid) AS total_pay'))
                                ->where('fuel_debt_payment.company_id',$cid)
                                ->get();
     $total_debt = DB::table('fuel_debts')
                                ->select(DB::raw('sum(diesel_cost*liters) AS total_debt'))
                                ->where('fuel_debts.company',$cid)
                                ->get();
                                
          $cdebts=DB::table('fuel_debts')
                   ->join('filling_stations','filling_stations.company_id','fuel_debts.company')
                    ->select('filling_stations.company_id'  , DB::raw('SUM(fuel_debts.diesel_cost*fuel_debts.liters ) as total_debts'))
                     ->groupBy('fuel_debts.fdid')
                     ->get();*/
      
    /* ->join('filling_stations','filling_stations.company_id','fuel_debts.company')*/
         return view('admin.cfuelDebt', compact('companies'));
      
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
         return view('admin.fuelDebt', compact('debts','company','total_debt','payments','total_pay'));
      
    }

     public function indexpdf($cid)
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

    public function indexppdf($cid)
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
    public function create()
    {
        //
        $companies=filling_station::all();
         $count=count(FuelDebt::all());
         $count++;
        $trucks = Truck::all();
         return view('admin.createfuelDebt', compact('trucks','count','companies'));
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
    
            return redirect()->route('admin-fuelDebt.index')
    
                    ->with('success','Debt Record Added successfully.');

    }

public function payment($id)
{
    # code...
    $filling_station=filling_station::find($id);
return view('admin.fuel_debt_payment',compact('filling_station'));


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
              return redirect()->route('admin-fuelDebt.cdebt',$company_id)->with('success','Fuel Debt Payment updated successfully');
          }else{
            return redirect()->route('admin-fuelDebt.index')->with('Error','Fuel Debt Payment update Fail');

}
  




}
    /**
     * Display the specified resource.
     *
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function show(FuelDebt $fuelDebt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FuelDebt  $fuelDebt
     * @return \Illuminate\Http\Response
     */
    public function edit(FuelDebt $fuelDebt)
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
    public function update(Request $request, FuelDebt $fuelDebt)
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
}

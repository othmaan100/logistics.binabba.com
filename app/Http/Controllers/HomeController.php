<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {

        $usernumb= count(User::all());
            $goods = Good::all();
        $earning= $goods->sum('good_cost'); 

        $goodlist = DB::table('tbl_good')
                ->latest()
                ->limit(7)
                ->get();
        $data=$goodlist->pluck('good_cost');
        $labels = $goodlist->pluck('good_date_of_pickup');

        $texpenses = Expense::all();
        $aexpenses = $texpenses->sum('expenses_cost');
      
        return view('admin.dashboard', compact('earning','usernumb','data','labels','aexpenses'));
    }


public function index2()
    {
         $goods = Good::all();
        $earning= $goods->sum('good_cost'); 

        $goodlist = DB::table('tbl_good')
                ->latest()
                ->limit(7)
                ->get();
        $data=$goodlist->pluck('good_cost');
        $labels = $goodlist->pluck('good_date_of_pickup');


      
        return view('home2', compact('earning','data','labels'));
    }

    public function chart1()
    {
        $goodlist = DB::table('tbl_good')
                ->latest()
                ->limit(7)
                ->get();
        $data=$goodlist->pluck('good_cost');
        $labels = $goodlist->pluck('good_date_of_pickup');

         $texpenses = DB::table('expenses')
                ->latest()
                ->limit(7)
                ->get();
        $expenses = $texpenses->pluck('expenses_cost');
        $dexpenses = $texpenses->pluck('expenses_date'); 

        return response()->json(compact('data','labels','expenses','dexpenses'));
        
       // return $weeklist;

    }
}

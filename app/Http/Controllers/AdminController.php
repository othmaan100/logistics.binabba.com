<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Good;
use App\Models\Stock;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\TruckPerformance;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function getActivityLogs(Request $request)
    {
        $logs = ActivityLog::join("users","users.id","user_id")
            ->select("activity_logs.*","users.fullName","users.email")
            ->orderByDesc("activity_logs.id")
            ->get();
        
        return view("admin.activityLog",compact("logs"));
    }

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

    return view('admin.dashboard', compact('total_funds','funds','totalFunds_this_month','totalfundsToday','usernumb',
    'total_expenses','totalExpenses_this_month','totalExpensesToday','inactiveusers','stock','undeliveredGoods','deliveredGoods','goodassignment_this_month','truckPerformance'));
         
    }

    
}

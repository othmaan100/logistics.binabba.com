<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Per-truck profitability for the dashboards.
 *
 * Uses the same formula as the truck Operations page (TruckController@operations):
 *   costs           = diesel (price x litres) + road expenses + commission + recorded expenses
 *   driver's share  = 10% of (goods cost - costs)
 *   total expenses  = costs + driver's share
 *   income operating = goods cost - total expenses
 *   balance         = truck value - income operating   (still to recover; > 0 means not paid back)
 *   net profit      = income operating - truck value
 */
class TruckPerformance
{
    public const PROFITABLE = 'profitable';
    public const RECOVERING = 'recovering';
    public const LOSS = 'loss';
    public const IDLE = 'idle';

    public static function all(): Collection
    {
        $goods = DB::table('tbl_good')
            ->select('truck_id')
            ->selectRaw('COUNT(*) AS trips')
            ->selectRaw('COALESCE(SUM(good_cost), 0) AS goods_cost')
            ->selectRaw('COALESCE(SUM(road_expenses), 0) AS road_expenses')
            ->selectRaw('COALESCE(SUM(commission), 0) AS commission')
            ->selectRaw('COALESCE(SUM(diesel_cost * liters), 0) AS diesel')
            ->groupBy('truck_id')
            ->get()
            ->keyBy('truck_id');

        $expenses = DB::table('expenses')
            ->join('tbl_good', 'tbl_good.good_id', '=', 'expenses.good_id')
            ->select('tbl_good.truck_id')
            ->selectRaw('COALESCE(SUM(expenses.expenses_cost), 0) AS amount')
            ->groupBy('tbl_good.truck_id')
            ->pluck('amount', 'truck_id');

        return DB::table('trucks')
            ->select('id', 'plate_number', 'truck_model', 'truck_price')
            ->orderBy('plate_number')
            ->get()
            ->map(function ($truck) use ($goods, $expenses) {
                $g = $goods->get($truck->id);

                $goodsCost = (float) ($g->goods_cost ?? 0);
                $costs = (float) ($g->diesel ?? 0) + (float) ($g->road_expenses ?? 0)
                    + (float) ($g->commission ?? 0) + (float) ($expenses[$truck->id] ?? 0);

                $driversShare = ($goodsCost - $costs) * 0.1;
                $totalExpenses = $costs + $driversShare;
                $income = $goodsCost - $totalExpenses;
                $value = (float) $truck->truck_price;

                $truck->trips = (int) ($g->trips ?? 0);
                $truck->goods_cost = $goodsCost;
                $truck->total_expenses = $totalExpenses;
                $truck->income = $income;
                $truck->value = $value;
                $truck->balance = $value - $income;
                $truck->profit = $income - $value;
                $truck->recovered = $value > 0 ? max(0, $income) / $value * 100 : null;

                $truck->status = match (true) {
                    $truck->trips === 0 => self::IDLE,
                    $income <= 0 => self::LOSS,
                    $truck->profit >= 0 => self::PROFITABLE,
                    default => self::RECOVERING,
                };

                return $truck;
            })
            // Problems first, then the ones furthest from paying back, best performers last
            ->sortBy(fn ($t) => [array_search($t->status, [self::LOSS, self::RECOVERING, self::PROFITABLE, self::IDLE]), $t->profit])
            ->values();
    }
}

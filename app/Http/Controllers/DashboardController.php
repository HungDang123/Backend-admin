<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function chart()
    {
        $order = Order::query()->with('items')
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, SUM(total_price) as total_price")
                ->groupBy('date')
                ->get();
        return response()->json($order);
    }
}

<?php

namespace App\Service;

use App\Models\Order;

class OrderService
{
    public function exportCsvStream(): array
    {
        $header = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];
        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Product Title', 'Quantity', 'Price', 'Total Price']);
            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    fputcsv($file, [$order->id, $order->name, $order->email, $item->product_title, $item->quantity, $item->price, $item->total_price]);
                }
            }
            fclose($file);
        };
        $res = [
            'header' => $header,
            'callback' => $callback,
        ];
        return $res;
    }
}
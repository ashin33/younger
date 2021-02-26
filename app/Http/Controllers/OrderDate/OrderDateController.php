<?php


namespace App\Http\Controllers\OrderDate;


use App\Models\OrderDate;
use Illuminate\Http\Request;

class OrderDateController
{
    public function index(Request $request)
    {
        $rows = OrderDate::query()->paginate(20);
        $rows->appends($request->all());
        return view('order_date.index')->with([
            'rows' => $rows
        ]);
    }
}
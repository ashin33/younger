<?php
/**
 * Created by PhpStorm, Author: 王云龙.
 * User: ALON
 * Date: 2021/1/17
 * Time: 18:28
 */

namespace App\Http\Controllers\Printer;


use App\Models\Order;
use App\Models\OrderDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class PrinterController
{
    public function manage(Request $request)
    {
        return view('printer.manage');
    }

    public function list(Request $request, $date)
    {
        $query = $this->query($request, $date);
        $rows = $query->paginate(20);
        $rows->appends($request->all());
        $buildings = Order::query()->where('order_date', '=', $date)->groupBy(['building'])->get(['building']);
        $floors = Order::query()->where('order_date', '=', $date)->groupBy(['floor'])->get(['floor']);
        $rooms = Order::query()->where('order_date', '=', $date)->groupBy(['room'])->get(['room']);
        return view('younger.order')->with([
            'rows' => $rows,
            'date' => $date,
            'buildings' => $buildings,
            'floors' => $floors,
            'rooms' => $rooms,
        ]);
    }

}
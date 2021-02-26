<?php
/**
 * Created by PhpStorm, Author: 王云龙.
 * User: ALON
 * Date: 2021/2/25
 * Time: 18:28
 */

namespace App\Http\Controllers\Application;


use App\Models\Application;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\Platform;
use App\Models\Printer;
use App\Models\TaxSource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ApplicationController
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $query = Application::query();
        $rows = $query->paginate(20);
        $rows->appends($request->all());
        return view('application.index')->with([
            'rows' => $rows,
        ]);
    }

    public function create()
    {
        return view('application.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $this->validate($request, [
            'name' => 'required|unique:applications,name',
            'client_id' => 'required',
            'client_secret' => 'required',
            'status' => 'required',
        ], [
            'name.required' => '请填写 应用名称',
            'name.unique' => '应用名称已存在',
            'client_id.required' => '请填写 打印机终端号',
            'client_secret.required' => '请填写 打印机终端密钥',
            'status.required' => '请选择 是否启用应用',
        ]);
        $enabledPrinter = Application::getEnabledApplication();
        if(!empty($enabledPrinter)){
            return back()->withErrors(['status' => '当前已有启用中的打印机'])->withInput();
        }
        try {
            $application = new Application();
            $application->fill([
                'name' => $data['name'],
                'client_id' => $data['client_id'],
                'client_secret' => $data['client_secret'],
                'status' => $data['status'],
            ]);
            $application->save();
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }
        return redirect()->route('application.index')->with([
            'success' => '操作成功'
        ]);
    }

}
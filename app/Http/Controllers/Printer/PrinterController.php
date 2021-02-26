<?php
/**
 * Created by PhpStorm, Author: 王云龙.
 * User: ALON
 * Date: 2021/2/25
 * Time: 18:28
 */

namespace App\Http\Controllers\Printer;


use App\Models\Application;
use App\Models\Printer;
use App\Service\YiLianYunService\ApplicationService;
use App\Service\YiLianYunService\PrinterService;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;


class PrinterController
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $query = Printer::query();
        $rows = $query->paginate(20);
        $rows->appends($request->all());
        $applications = Application::query()->get();
        return view('printer.index')->with([
            'rows' => $rows,
            'applications' => $applications,
        ]);
    }

    public function create()
    {
        return view('printer.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');

        $this->validate($request, [
            'name' => 'unique:printers,name',
            'machine_code' => 'required',
            'm_sign' => 'required',
            'status' => 'required',
        ], [
            'name.unique' => '打印机名称已存在',
            'machine_code.required' => '请填写 打印机终端号',
            'm_sign.required' => '请填写 打印机终端密钥',
            'status.required' => '请选择 是否启用打印机',
        ]);
        $enabledPrinter = Printer::getEnabledPrinter();
        if(!empty($enabledPrinter)){
            return back()->withErrors(['status' => '当前已有启用中的打印机'])->withInput();
        }
        try {
            $printer = new Printer();
            $printer->fill([
                'name' => $data['name'],
                'machine_code' => $data['machine_code'],
                'm_sign' => $data['m_sign'],
                'status' => $data['status'],
                'auth_status' => Printer::PRINTER_UNAUTHORIZED
            ]);
            $printer->save();
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ])->withInput();
        }
        return redirect()->route('printer.index')->with([
            'success' => '操作成功'
        ]);
    }

    public function authorize(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        $application_id = $data['application_id'];
        /**
         * @var $printer Printer
         * @var $application Application
         */
        $printer = Printer::query()->find($id);
        if(empty($printer)){
            return response()->json(['code' => 201, 'msg' => '打印机不存在']);
        }
        $application = Application::query()->find($application_id);
        if(empty($application)){
            return response()->json(['code' => 201, 'msg' => '应用不存在']);
        }
        $application_service = new ApplicationService($application);
        try{
            $access_token = $application_service->getToken();
        }catch (\Exception $exception){
            return response()->json(['code' => 201, 'msg' => $exception->getMessage()]);
        }
        $config = $application_service->getConfig();
        $printerService = new PrinterService($access_token, $config);
        $machine_code = $printer->getMachineCode();
        $m_sign = $printer->getMSign();
        $res = $printerService->addPrinter($machine_code,$m_sign, 'order');
        if($printerService->isSuccess($res)){
            $printer->setAuthorized();
            return response()->json(['code' => 200, 'msg' => '授权成功']);
        }else{
            return response()->json(['code' => 201, 'msg' => $printerService->getErrorMsg($res)]);
        }
    }
}
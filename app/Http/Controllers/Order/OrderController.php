<?php
/**
 * Created by PhpStorm, Author: 王云龙.
 * User: ALON
 * Date: 2021/1/17
 * Time: 18:28
 */

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\V1Order;
use App\Models\Printer;
use App\Service\YiLianYunService\ApplicationService;
use App\Service\YiLianYunService\PrintService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class OrderController extends Controller
{

    public function index(Request $request, $date)
    {
        $query = $this->query($request, $date);
        $rows = $query->paginate(20);
        $rows->appends($request->all());
        $buildings = V1Order::query()->where('order_date', '=', $date)->groupBy(['building'])->get(['building']);
        $floors = V1Order::query()->where('order_date', '=', $date)->groupBy(['floor'])->get(['floor']);
        $rooms = V1Order::query()->where('order_date', '=', $date)->groupBy(['room'])->get(['room']);
        return view('order.index')->with([
            'rows' => $rows,
            'date' => $date,
            'buildings' => $buildings,
            'floors' => $floors,
            'rooms' => $rooms,
        ]);
    }

    public function download(Request $request, $date)
    {
        $query = $this->query($request, $date);
        $data = $query->get();
        $spans = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ'];


        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getDefaultColumnDimension()->setWidth(19);
        $row = 1;
        //表头
        $title = ['订单号', '应付', '楼号', '楼层', '科室', '姓名', '电话', '套餐', '盖浇饭', '汤煲', '加饭', '备注', '下单时间'];
        foreach ($title as $key => $value) {
            // 单元格内容写入
            $sheet->setCellValue($spans[$key] . $row, $value);
        }
        $row++;

        foreach ($data as $v) {
            $data = [
                $v->serial_number,
                $v->total_price,
                $v->building,
                $v->floor,
                $v->room,
                $v->contact_person,
                $v->phone,
                $v->set_meal,
                $v->rice_bowl,
                $v->soup_pot,
                $v->extra_meal,
                $v->remark,
                $v->created_at
            ];
            foreach ($data as $key => $value) {
                // 单元格内容写入
                $sheet->setCellValue($spans[$key] . $row, $value);
                $sheet->getStyle($spans[$key] . $row)->getAlignment()->setWrapText(true);
            }
            $row++;
        }
        $file_name = 'order' . $date;
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $file_name . '.xlsx"');
        header("Content-Disposition:attachment;filename=$file_name.xlsx");//attachment新窗口打印inline本窗口打印
        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');
    }

    protected function query(Request $request, $date): Builder
    {
        $query = V1Order::query()->where('order_date', '=', $date);
        if ($request->get('building')) {
            $query->where('building', '=', $request->get('building'));
        }
        if ($request->get('floor')) {
            $query->where('floor', '=', $request->get('floor'));
        }
        if($request->get('room'))
        {
            $query->where('room', '=', $request->get('room'));
        }
        if($request->get('sort'))
        {
            $query->orderBy($request->get('sort'));
        }else{
            $query->orderByDesc('id');
        }

        return $query;
    }

    public function print(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        /**
         * @var $order V1Order
         */
        $order = V1Order::query()->find($id);
        if(empty($order)){
            return response()->json(['code' => 201, 'msg' => '订单不存在']);
        }
        /**
         * @var $application Application
         * @var $printer Printer
         */
        $application = Application::getEnabledApplication();
        $printer = Printer::getEnabledPrinter();
        $machine_code = $printer->getMachineCode();

        $application_service = new ApplicationService($application);
        try{
            $access_token = $application_service->getToken();
        }catch (\Exception $exception){
            return response()->json(['code' => 201, 'msg' => $exception->getMessage()]);
        }
        $config = $application_service->getConfig();


        $printService = new PrintService($access_token, $config);

        try{
            $res = $printService->print($machine_code, $order);
        }catch (\Exception $e) {
            return response()->json(['code' => 201, 'msg' => $e->getMessage()]);
        }
        if($printService->isSuccess($res)){
            $order->setPrintSuccess();
            return response()->json(['code' => 200, 'msg' => '已推送打打印队列']);
        }else{
            $order->setPrintFAIL($printService->getErrorMsg($res));
            return response()->json(['code' => 201, 'msg' => $printService->getErrorMsg($res)]);
        }
    }
}
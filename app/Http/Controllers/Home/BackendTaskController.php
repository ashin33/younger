<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use App\Models\BackendDownload;
use Illuminate\Http\Request;

class BackendTaskController extends BaseController
{
    public function index(Request $request){

        $query = BackendDownload::query()
            ->where('admin_id', '=', admin()->id)->with('admin')
            ->backend()
            ->orderBy('id', 'desc');

        $rows = $query->paginate();
        $rows->appends($request->toArray());
        return view('home.backend_download-index')->with([
            'rows' => $rows
        ]);

    }

    public function destroy($id)
    {
        $row = BackendDownload::query()->find($id);
        if(!empty($row)){
            if(file_exists($row->getAttribute('storage_path'))){
                unlink($row->getAttribute('storage_path'));
            }
            $row->delete();
        }

        return redirect()->route('home::backend_task.index');
    }
}

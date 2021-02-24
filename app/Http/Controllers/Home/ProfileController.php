<?php
/**
 * Created by PhpStorm, Author: 刘迎春.
 * User: Breeze
 * Date: 2017/12/26
 * Time: 下午4:31
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{

    public function show(Request $request)
    {

        $row = admin();
        $is_initial =$row->is_initial == 1 ? true : false;
        if ($request->get('info') == 'password') {
            return view('profile.profile-password')->with(['row' => $row, 'is_initial' => $is_initial]);
        }

        return view('profile.profile-show')->with(['row' => $row]);
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'origin_password' => 'required|min:6',
            'password' => [
                'required',
                'min:6',
                'confirmed',
                'alpha_num',
                'regex:/^(?:\d.*_)|(?:_.*\d)|(?:[A-Za-z].*_)|(?:_.*[A-Za-z])|(?:[A-Za-z].*\d)|(?:\d.*[A-Za-z])$/'
            ]
        ]);

        $row = admin();

        $oldPassword = $row->getAttribute('password');

        // 检查原密码
        if (!Hash::check($request->get('origin_password'), $oldPassword)) {
            session()->flash('password_error', '原密码输入不正确');
            return redirect()->back()->withInput($request->all());
        }

        // 检查新密码与原密码是否相同
        if (Hash::check($request->get('password'), $oldPassword)) {
            session()->flash('password_error', '新密码不可与原密码相同');
            return redirect()->back()->withInput($request->all());
        }


        $row->setPassword($request->get('password'));
        $row->setAttribute('is_initial', 0);
        if ($row->update()) {
            $row->unlock($row->getAttribute('email'));
            auth()->logout();
            $request->session()->invalidate();
            return redirect('login');
        }

        return redirect()->back();
    }

    public function resetPassword(){

    }

}
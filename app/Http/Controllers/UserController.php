<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateInformation;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->roles()->attach(Role::findOrFail($request->input('roles')));

        return redirect()->back()->with('status', 'Thêm User Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        $user = User::findOrFail($id);
        $user->update($input);
        DB::table('role_user')->where('user_id', $id)->delete();
        $user->roles()->attach(Role::findOrFail($request->input('roles')));

        return redirect()->back()->with('status', 'Cập Nhật User Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();
        DB::table('role_user')->where('user_id', $id)->delete();

        return response()->json();
    }

    public function editInformation()
    {
        $user_id = \Auth::id();
        $user = User::findOrFail($user_id);

        return view('users.information', compact('user'));
    }

    public function updateInformation(UpdateInformation $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->update();

        return redirect()->back()->with('status', 'Cập nhật thông tin tài khoản thành công');
    }

    /**
     * Update the password for the user.
     *
     * @param  Request $request
     * @return Response
     */
    public function updatePassword(UpdatePassword $request)
    {
        // Verifying A Password Against A Hash
        if (\Hash::check($request->input('current_password'), \Auth::user()->getAuthPassword())) {
            $request->user()->fill([
                'password' => \Hash::make($request->password),
            ])->save();

            return redirect()->back()->with('status', 'Cập Nhật Mật Khẩu Thành Công');
        } else {
            return redirect()->back()->with('error', 'Mật Khẩu Cũ Không Đúng');
        }
    }
}

<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\UserM2MRole;
use App\Models\UserType;
use App\Models\Views\RoleM2mUserType;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $model = \App\Models\Views\User::orderBy('id')->get();

        foreach ($model as $k => &$v3) {

            $v3['role_arr'] = explode(',', $v3['role_arr']);

            $ViewRoleM2mUserType = RoleM2mUserType::pluck('roleObj', 'user_type_id')->toArray();
            foreach ($ViewRoleM2mUserType as $k5 => &$v5) {
                $v5 = json_decode("[$v5]");
            }

            $t = $ViewRoleM2mUserType[$v3['user_type_id']];

            foreach ($t as $k2 => &$v2) {

                if (in_array($v2->id, $v3['role_arr'])) {
                    $v2->checked = true;

                } else {
                    $v2->checked = false;
                }
            }
            $v3['role_obj'] = $t;
        }
        $model = json_encode($model);
        $UserTypeArr = UserType::pluck('title', 'id');

        return view('index', [
            'model' => $model,
            'UserTypeArr' => $UserTypeArr
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function find(Request $request)
    {
        if ($request->keyword) {
            $model = \App\Models\Views\User::where('full_name', 'LIKE', "%{$request->keyword}%")->orderBy('id')->get();
        }
        if ($request->date_to) {

            $model = \App\Models\Views\User::whereDate('created_at', '<', $request->date_to)
                ->orderBy('id')->get();
        }
        if ($request->date_from) {
            $model = \App\Models\Views\User::whereDate('created_at', '>', $request->date_from)
                ->orderBy('id')->get();
        }
        if ($request->keyword && $request->date_to) {


            $model = \App\Models\Views\User::where('full_name', 'LIKE', "%{$request->keyword}%")
                ->whereDate('created_at', '<', $request->date_to)
                ->orderBy('id')->get();
        }
        if ($request->keyword && $request->date_from) {

            $model = \App\Models\Views\User::where('full_name', 'LIKE', "%{$request->keyword}%")
                ->whereDate('created_at', '>', $request->date_from)
                ->orderBy('id')->get();
        }
        if ($request->date_from && $request->date_to) {


            if (strtotime($request->date_from) < strtotime($request->date_to)) {
                $model = \App\Models\Views\User::where('full_name', 'LIKE', "%{$request->keyword}%")
                    ->whereDate('created_at', '>', $request->date_from)
                    ->orderBy('id')->get();
            } else {
                $list = [
                    'status' => 'error',
                    'message' => 'Дата "С" больше даты "По"',
                ];
                return $list;
            }
        }
        if ($request->keyword && $request->date_from && $request->date_to) {
            if ($request->date_from < $request->date_to) {
                $model = \App\Models\Views\User::where('full_name', 'LIKE', "%{$request->keyword}%")
                    ->whereDate('created_at', '>', $request->date_from)
                    ->whereDate('created_at', '<', $request->date_to)
                    ->orderBy('id')->get();
            } else {
                $list = [
                    'status' => 'error',
                    'message' => 'Дата "С" больше даты "По"',
                ];
                return $list;
            }
        }


        foreach ($model as $k => &$v3) {

            $v3['role_arr'] = explode(',', $v3['role_arr']);

            $ViewRoleM2mUserType = RoleM2mUserType::pluck('roleObj', 'user_type_id')->toArray();
            foreach ($ViewRoleM2mUserType as $k5 => &$v5) {
                $v5 = json_decode("[$v5]");
            }

            $t = $ViewRoleM2mUserType[$v3['user_type_id']];

            foreach ($t as $k2 => &$v2) {

                if (in_array($v2->id, $v3['role_arr'])) {
                    $v2->checked = true;

                } else {
                    $v2->checked = false;
                }
            }
            $v3['role_obj'] = $t;
        }

        $list = [
            'status' => 'success',
            'data' => $model
        ];

        return $list;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = \App\Models\Views\User::find($id);

        $UserTypeArr = UserType::pluck('title', 'id');
//////////////////////////
        $ViewUserM2mRole = \App\Models\Views\UserM2mRole::where('user_id', $id)->get()->toArray();
        $ViewUserM2mRole = $ViewUserM2mRole[0];
//        dd($ViewUserM2mRole);
        $ViewUserM2mRole['roleArr'] = explode(',', $ViewUserM2mRole['roleArr']);



        $ViewRoleM2mUserType = RoleM2mUserType::pluck('roleObj', 'user_type_id')->toArray();
        foreach ($ViewRoleM2mUserType as $k5 => &$v5) {
            $v5 = json_decode("[$v5]");
        }

        $checkboxArr = $ViewRoleM2mUserType;

        foreach ($checkboxArr as $k => $v) {
            foreach ($v as $k2 => &$v2) {
                if ($k == $model->user_type_id && in_array($v2->id, $ViewUserM2mRole['roleArr'])) {
                    $v2->checked = true;
                } else {
                    $v2->checked = false;
                }
            }
        }

        $checkboxArr = json_encode($checkboxArr);

        if ($model) {
            return view('edit', [
                'model' => $model,
                'checkboxArr' => $checkboxArr,
                'UserTypeArr' => $UserTypeArr,
            ]);
        } else {
            return redirect()->route('index')->withErrors(['Запись не найдена']);
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $UserTypeArr = UserType::pluck('title', 'id');
        $ViewRoleM2mUserType = RoleM2mUserType::all();
        $checkboxArr = [];

        foreach ($ViewRoleM2mUserType as $k => $v) {
            $checkboxArr[$v->user_type_id] = json_decode("[$v->roleObj]");
            foreach ($checkboxArr[$v->user_type_id] as $k2 => &$v2) {
                $v2->checked = false;
            }
        }

        $checkboxArr = json_encode($checkboxArr);

        return view('create', [
            'checkboxArr' => $checkboxArr,
            'UserTypeArr' => $UserTypeArr,
        ]);
    }

    public function update(UpdateUser $request)
    {
        $user = User::where('id', $request->id)->update(
            [
                "full_name" => $request->full_name,
                "birthday_date" => $request->birthday_date,
                "user_type_id" => $request->user_type_id,
            ]);

        if ($request->id) {
            UserM2MRole::where('user_id', $request->id)->delete();
        }

        if ($request->role) {
            foreach ($request->role as $key => $value) {
                \App\Models\UserM2MRole::create([
                    'user_id' => $request->id,
                    'role_id' => $key
                ]);
            }
        }
        return redirect()->back();
    }

    /**
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {
        $user = User::Create([
                "full_name" => $request->full_name,
                "birthday_date" => $request->birthday_date,
                "organization" => $request->organization,
                "user_type_id" => $request->user_type_id,
            ]);

        if ($request->role) {
            foreach ($request->role as $key => $value) {
                \App\Models\UserM2MRole::create([
                    'user_id' => $user->id,
                    'role_id' => $key
                ]);
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        User::destroy($request->id);
    }


    /**
     * @param Request $request
     * @return array
     */
    public function update2(Request $request)
    {
        foreach ($request->model as $k => $v) {
            $valid = false;
            foreach ($v['role_obj'] as $k2 => $v2) {
                if ($v2['checked'] == true) {
                    $valid = true;
                }
            }
            if (!$valid) {
                $list = [
                    'status' => 'error',
                    'message' => 'Нужно проставить хотя бы одну галочку, каждому пользователю',
                ];
                return $list;
            }
        }

        foreach ($request->model as $k => $v) {

            if ($v['id']) {
                UserM2MRole::where('user_id', $v['id'])->delete();
            }

            if ($v['role_obj']) {
                foreach ($v['role_obj'] as $k2 => $v2) {
                    if ($v2['checked']) {
                        \App\Models\UserM2MRole::create([
                            'user_id' => $v['id'],
                            'role_id' => $v2['id']
                        ]);
                    }
                }
            }
        }
    }
}

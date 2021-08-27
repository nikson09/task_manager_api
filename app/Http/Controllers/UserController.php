<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $users = User::query()->select(
    'id',
            'name',
            'email'
        );

        if ($request->has('filters')) {
            foreach($request->input('filters') as $filter){
                $users->where($filter['column'], $filter['value']);
            }
        }

        if ($request->has('sort')) {
            $sorting = $request->input('sort');

            if (!empty($sorting['column']) && !empty($sorting['order'])) {
                $order = 'asc';

                if ($sorting['order'] == 'descending') {
                    $order = 'desc';
                }

                $users->orderBy($sorting['column'], $order);
            }
        }

        return response()->json([
            'users' => $users->paginate($request->input('count', 10))
        ]);
    }
}

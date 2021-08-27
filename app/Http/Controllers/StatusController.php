<?php

namespace App\Http\Controllers;

use App\Status;
use App\Http\Requests\CreateStatus;
use App\Http\Requests\UpdateStatus;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function getStatuses(Request $request)
    {
        $statuses = Status::query();

        if ($request->has('filters')) {
            foreach($request->input('filters') as $filter){
                $statuses->where($filter['column'], $filter['value']);
            }
        }

        if ($request->has('sort')) {
            $sorting = $request->input('sort');

            if (!empty($sorting['column']) && !empty($sorting['order'])) {
                $order = 'asc';

                if ($sorting['order'] == 'descending') {
                    $order = 'desc';
                }

                $statuses->orderBy($sorting['column'], $order);
            }
        }

        $statuses->where('active', true);

        return response()->json([
            'statuses' => $statuses->paginate($request->input('count', 10))
        ]);
    }

    public function createStatus(CreateStatus $request)
    {
        $status = Status::create($request->all());

        return response()->json([
            'message' => 'success',
            'status' => $status
        ]);
    }

    public function updateStatus(UpdateStatus $request, $id)
    {
        $status = Status::find($id);

        if(empty($status)){
            abort(404);
        }

        $status->update($request->all());

        return response()->json([
            'message' => 'success',
            'status' => $status
        ]);
    }

    public function deleteStatus($id)
    {
        $status = Status::find($id);

        if(empty($status)){
            abort(404);
        }

        $status->update(['active' => false]);

        return response()->json([
            'message' => 'success'
        ]);
    }
}

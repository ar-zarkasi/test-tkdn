<?php

namespace App\Services;

use App\Interfaces\ToDoInterface;
use Illuminate\Support\Facades\{
    Hash,
    Validator,
    Auth,
    Password,
    DB
};

use App\Traits\ReturnServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Resources\ToDoResource;

class ToDoTask
{
    use ReturnServices;

    protected $todoRepository;

    public function __construct(ToDoInterface $todointerface)
    {
        $this->todoRepository = $todointerface;
    }

    public function add(Request $request)
    {
        $userlogin = $request->user;
        $params = $request->all();
        DB::beginTransaction();
        try {
            $task = $this->todoRepository->store($params);
            $collection = (new ToDoResource($task))->jsonSerialize();
            DB::commit();
            return $this->response($collection,'Created Task Successfully', false, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(null,$th->getMessage(), true, 500);
        }
    }

    public function edit($id, Request $request)
    {
        $userlogin = $request->user;
        $params = $request->all();
        DB::beginTransaction();
        try {
            $task = $this->todoRepository->getTaskById($id);
            if(!$task->id) {
                throw new \Exception('Task Not Found', 404);
            }
            if($task->id_user != $userlogin->id) {
                throw new \Exception('Your not authorize to update this task', 401);
            }
            $update = $this->todoRepository->update($task, $params);
            $collection = (new ToDoResource($update))->jsonSerialize();
            DB::commit();
            return $this->response($collection,'Updating Task Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(null,$th->getMessage(), true, 500);
        }
    }

    public function get(Request $request)
    {
        $userlogin = $request->user;
        $params = $request->all();
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $data = $this->todoRepository->getAllTask($userlogin->uuid, $limit);
        $collection = ToDoResource::collection($data)->jsonSerialize();
        return $this->response($collection,'fetch data successfully');
    }

    public function delete(int $id, int $iduser)
    {
        $data = $this->todoRepository->getTaskById($id);
        DB::beginTransaction();
        try {
            if($data->id_user != $iduser) {
                throw new \Exception('Your Not Authorized to delete this task');
            }
            $data->delete();
            DB::commit();
            return $this->response(null,'delete task data successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->response(null,$th->getMessage(), true, 500);
        }
    }
}
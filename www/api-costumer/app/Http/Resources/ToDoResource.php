<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ToDoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'task'=> $this->task,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
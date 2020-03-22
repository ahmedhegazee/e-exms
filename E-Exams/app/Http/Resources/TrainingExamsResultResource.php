<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingExamsResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $date = new \DateTime($this->result->created_at);
        return [
            'score'=>$this->result->marks,
            'date'=>$date->format('d-m-Y h:i:sa')
        ];
    }
}

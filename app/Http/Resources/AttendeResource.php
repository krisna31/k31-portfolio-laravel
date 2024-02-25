<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->user),
            // 'attende_code_id' => $this->attende_code_id,
            'attende_code' => new AttendeCodeResource($this->attendeCode),
            // 'approval_status_id' => $this->approval_status_id,
            'approval_status' => new ApprovalStatusResource($this->approvalStatus),
            // 'attende_status_id' => $this->attende_status_id,
            'attende_status' => new AttendeStatusResource($this->attendeStatus),
            'attende_time' => Carbon::parse($this->attende_time)->format('Y-m-d H:i:s'),
            'address' => $this->address,
            'photo' => $this->photo,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeCodeResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'linkAbsensi';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'default_approval_status_id' => $this->default_approval_status_id,
            'is_open' => $this->is_open,
            'is_attended' => $this->is_attended,
            'description' => $this->description,
            // 'attende_type_id' => $this->attende_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'attende_type' => new AttendeTypeResource($this->attendeType),
            'user' => new UserResource($this->user),
            'default_approval_status' => new ApprovalStatusResource($this->defaultApprovalStatus),
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}

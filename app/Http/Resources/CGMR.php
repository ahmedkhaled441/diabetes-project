<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CGMR extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'current_glucose' => $this->current_glucose,
            'predicted_glucose' => $this->predicted_glucose,
            'trend' => $this->trend,
            'suggested_action' => $this->suggested_action,
            'plot_image' => 'data:image/png;base64,' . $this->plot_base64, // Inline image
            // 'plot_image' => $this->plot_url,
        ];
    }
}

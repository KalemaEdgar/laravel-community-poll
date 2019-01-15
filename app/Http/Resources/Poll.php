<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Poll extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // Incase you want to transform your API response, use the below but it only displays the title
        // Manipulate the response back from the api to show only 15 chars and add the dots to show that data is continuing
        // return [
        //     "title" => mb_strimwidth($this->title, 0, 15, "...")
        // ];
    }
}

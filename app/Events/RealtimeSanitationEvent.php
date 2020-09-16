<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeSanitationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(){

        return ['sanitation'];
    }

    public function broadcastAs(){
        return 'realtime';
    }

    public function broadcastWith(){

        if($this->data['checked'] == 'MarkUnidentified'){

            return [
                'status' => $this->data['status'],
                'user_id' => $this->data['user_id'],
                'checked' => $this->data['checked'],
                'sanitizeRow' => $this->data['sanitizeRow'],
                'unsanitizeRow' => $this->data['unsanitizeRow'],
                'doneToUnidentified' => $this->data['doneToUnidentified'],
            ];
        }

        if($this->data['checked'] == 'MarkAsSanitized'){

            return [
                'status' => $this->data['status'],
                'user_id' => $this->data['user_id'],
                'checked' => $this->data['checked'],
                'sanitizeRow' => $this->data['sanitizeRow'],
                'unsanitizeRow' => $this->data['unsanitizeRow'],
                'doneToSanitized' => $this->data['doneToSanitized'],
            ];
        }

        if($this->data['checked'] == 'filter'){
            
            if($this->data['count'] > 0){
                return [
                    'status' => $this->data['status'],
                    'checked' => $this->data['checked'],
                    'selected' => $this->data['selected'],
                    'avatar' => $this->data['avatar'],
                ];
            }else{
                 return [
                    'status' => $this->data['status'],
                    'checked' => $this->data['checked'],
                    'selected' => $this->data['selected']
                ];
            }

        }


        if($this->data['checked'] == 'checkall'){

            return [
                'status' => $this->data['status'],
                'user_id' => $this->data['user_id'],
                'name' => $this->data['name'],
                'raw_ids' => $this->data['raw_ids'],
                'checked' => $this->data['checked'],
                'checkrows' => $this->data['checkrows'],
                'color' => $this->data['color'],
                'avatar' => $this->data['avatar'],
            ];
        }

        if($this->data['checked'] == 'unchecked'){

            return [
                'status' => $this->data['status'],
                'user_id' => $this->data['user_id'],
                'raw_id' => $this->data['raw_id'],
                'checked' => $this->data['checked'],
            ];
        }

        if($this->data['checked'] == 'checked'){

            return [
                'status' => $this->data['status'],
                'user_id' => $this->data['user_id'],
                'raw_id' => $this->data['raw_id'],
                'checked' => $this->data['checked'],
                'color' => $this->data['color'],
                'avatar' => $this->data['avatar'],
            ];
        }
    }
}
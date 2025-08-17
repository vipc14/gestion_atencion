<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\AttentionQueue;
    use App\Models\AttentionExecutive;

    class AttentionController extends Controller
    {
        public function getQueues($channel_id)
        {
            $queues = AttentionQueue::where('attention_channel_id', $channel_id)->get();
            return response()->json($queues);
        }

        public function getExecutives($queue_id)
        {
            $executives = AttentionExecutive::where('attention_queue_id', $queue_id)->get();
            return response()->json($executives);
        }
    }

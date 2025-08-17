<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\LineType;
    use App\Models\ClientType;

    class LineInfoController extends Controller
    {
        public function getClientTypes($line_type_id)
        {
            $lineType = LineType::find($line_type_id);
            return response()->json($lineType ? $lineType->clientTypes : []);
        }

        public function getSegments($client_type_id)
        {
            $clientType = ClientType::find($client_type_id);
            return response()->json($clientType ? $clientType->segments : []);
        }
    }
    
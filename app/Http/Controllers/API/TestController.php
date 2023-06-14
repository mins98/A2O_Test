<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Problem_one;
use Problem_two;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function queensAttack(Request $request)
    {
        try {

            $problem = new Problem_one; 
            
            $data= $problem->queenPositions($request);
            return response()->json([$data]);

        } catch (error $error) {
            return response()->json([$error]);
    
        }
    }

    public function stringValues(Request $request)
    {
       try {
            
            $problem = new Problem_two; 
            $data= $problem->stringIterations($request->text);
            return response()->json([$data]);

        } catch (error $error) {
            return response()->json([$error]);
    
        }
    }

    
}

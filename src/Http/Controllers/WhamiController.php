<?php

namespace Yomo7\Whami\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yomo7\Whami\Models\WhamiKeyword;
use Yomo7\Whami\Whami;

class WhamiController extends Controller
{
    /**
     * Process a keyword from an incoming request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processKeyword(Request $request)
    {
        $input = $request->input('keyword');
        $number = $request->input('number');
        
        $result = Whami::processKeyword($input, $number);
        
        if ($result) {
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid keyword format'
        ], 400);
    }
    
    /**
     * Get keywords by number
     *
     * @param Request $request
     * @param string $number
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKeywordsByNumber(Request $request, string $number)
    {
        $keywords = WhamiKeyword::getByNumber($number);
        
        return response()->json([
            'success' => true,
            'data' => $keywords
        ]);
    }
    
    /**
     * Get keywords by attribution code
     *
     * @param Request $request
     * @param string $attributionCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKeywordsByAttributionCode(Request $request, string $attributionCode)
    {
        $keywords = WhamiKeyword::getByAttributionCode($attributionCode);
        
        return response()->json([
            'success' => true,
            'data' => $keywords
        ]);
    }
}

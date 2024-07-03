<?php

namespace App\Http\Controllers;

use App\Http\Requests\RespondentRequest;
use App\Models\Respondent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    //Display all Respondent
    public function index()
    {
        $respondent = Respondent::all();

        if ($respondent->isEmpty()) {
            return response()->json([
                'message' => 'There no Respondent',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'message' => 'Successfully Display Respondent',
                'data' => $respondent,
            ], 200);
        }
    }

    // Store Respondent inside Database
    public function store(RespondentRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['name'] = $data['name'];
        $data['age'] = $data['age'];
        $data['location'] = $data['location'];
        $data['income'] = $data['income'];
        $data['occupation'] = $data['occupation'];

        $respondent = Respondent::create($data);

        return response()->json([
            'message' => 'Created Successfully',
            'data' => $respondent,
        ], 200);
    }
}

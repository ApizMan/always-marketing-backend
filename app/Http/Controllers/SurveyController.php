<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    //Display all Survey
    public function index()
    {
        $survey = Survey::all();

        if ($survey->isEmpty()) {
            return response()->json([
                'message' => 'There no Survey have been created',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'message' => 'Successfully Display Survey',
                'data' => $survey,
            ], 200);
        }
    }

    // Store Survey inside Database
    public function store(SurveyRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['title'] = $data['title'];
        $data['description'] = $data['description'];
        $data['created_by'] = auth()->user()->id;

        $survey = Survey::create($data);

        return response()->json([
            'message' => 'Created Successfully',
            'data' => $survey,
        ], 200);
    }

    // Update Survey inside Database
    public function edit(Request $request, $id): JsonResponse
    {

        $survey = Survey::find($id);
        $survey->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        return response()->json(
            [
                'message' => "Survey Updated Successfully",
                'data' => $survey,
            ],
        );
    }

    //  Delete Survey
    public function destroy($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json([
                'message' => 'The survey does not exist',
            ], 404);
        } else {
            $survey->delete($survey);
            return response()->json([
                'message' => 'Successfully Deleted Survey',
                'data' => null,
            ], 200);
        }
    }
}

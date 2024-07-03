<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //Display all Question
    public function index($id)
    {
        $question = Question::where('survey_id', $id)->get();

        if ($question->isEmpty()) {
            return response()->json([
                'message' => 'There no Question have been created',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'message' => 'Successfully Display Question',
                'data' => $question,
            ], 200);
        }
    }

    // Store Question inside Database
    public function store(QuestionRequest $request, $id): JsonResponse
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json([
                'message' => 'Create Survey first',
            ], 404);
        } else {
            $data = $request->validated();

            $data['question_text'] = $data['question_text'];
            $data['question_type'] = $data['question_type'];
            $data['survey_id'] = $survey->id;

            $question = Question::create($data);

            return response()->json([
                'message' => 'Created Successfully',
                'data' => $question,
            ], 200);
        }
    }

    // Update Question inside Database
    public function edit($id, Request $request, $q_id): JsonResponse
    {

        $question = Question::find($q_id);
        $question->update([
            'question_text' => $request->input('question_text'),
            'question_type' => $request->input('question_type'),
            'survey_id' => $id,
        ]);
        return response()->json(
            [
                'message' => "Question Updated Successfully",
                'data' => $question,
            ],
        );
    }

    //  Delete Question
    public function destroy($id, $q_id)
    {
        $question = Question::find($q_id);

        if (!$question) {
            return response()->json([
                'message' => 'The Question does not exist',
            ], 404);
        } else {
            $question->delete($question);
            return response()->json([
                'message' => 'Successfully Deleted Question',
                'data' => null,
            ], 200);
        }
    }
}

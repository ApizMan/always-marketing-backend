<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Respondent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    //Display all Answer
    public function index($s_id, $q_id)
    {
        $answer = Answer::where('question_id', $q_id)->get();

        if ($answer->isEmpty()) {
            return response()->json([
                'message' => 'There no Answer have been created',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'message' => 'Successfully Display Answer',
                'data' => $answer,
            ], 200);
        }
    }

    // Store Answer inside Database
    public function store($s_id, $q_id, AnswerRequest $request, $r_id): JsonResponse
    {
        $question = Question::find($q_id);
        // dd($q_id);

        $respondent = Respondent::find($r_id);

        if (!$question) {
            return response()->json([
                'message' => 'Create Question first',
            ], 404);
        } elseif (!$respondent) {
            return response()->json([
                'message' => 'Create Respondent first',
            ], 404);
        } else {
            $data = $request->validated();

            $data['answer_text'] = $data['answer_text'];
            $data['question_id'] = $question->id;
            $data['respondent_id'] = $respondent->id;

            $answer = Answer::create($data);

            return response()->json([
                'message' => 'Created Successfully',
                'data' => $answer,
            ], 200);
        }
    }

    // // Update Answer inside Database
    // public function edit($q_id, Request $request, $id): JsonResponse
    // {

    //     $answer = Answer::find($id);
    //     $answer->update([
    //         'question_text' => $request->input('question_text'),
    //         'question_type' => $request->input('question_type'),
    //         'survey_id' => $q_id,
    //     ]);
    //     return response()->json(
    //         [
    //             'message' => "Answer Updated Successfully",
    //             'data' => $answer,
    //         ],
    //     );
    // }

    // //  Delete Answer
    // public function destroy($q_id, $id)
    // {
    //     $answer = Answer::find($id);

    //     if (!$answer) {
    //         return response()->json([
    //             'message' => 'The Answer does not exist',
    //         ], 404);
    //     } else {
    //         $answer->delete($answer);
    //         return response()->json([
    //             'message' => 'Successfully Deleted Answer',
    //             'data' => null,
    //         ], 200);
    //     }
    // }
}

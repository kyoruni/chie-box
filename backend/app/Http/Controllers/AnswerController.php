<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{
    public function store(StoreAnswerRequest $request, Question $question): JsonResponse
    {
        $answer = Answer::create([
            ...$request->validated(),
            'question_id' => $question->id,
        ]);

        return response()->json(['data' => $answer], 201);
    }

    public function update(UpdateAnswerRequest $request, Answer $answer): JsonResponse
    {
        $answer->update($request->validated());

        return response()->json(['data' => $answer]);
    }

    public function destroy(Answer $answer): JsonResponse
    {
        $answer->delete();

        return response()->json(null, 204);
    }
}

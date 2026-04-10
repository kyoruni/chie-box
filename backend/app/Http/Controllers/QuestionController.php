<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    public function index(): JsonResponse
    {
        $questions = Question::with('category')
            ->withCount('answers')
            ->latest()
            ->get();

        return response()->json(['data' => $questions]);
    }

    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $question = Question::create($request->validated());

        return response()->json(['data' => $question], 201);
    }

    public function show(Question $question): JsonResponse
    {
        $question->load(['category', 'answers.user']);

        return response()->json(['data' => $question]);
    }

    public function update(UpdateQuestionRequest $request, Question $question): JsonResponse
    {
        $question->update($request->validated());

        return response()->json(['data' => $question]);
    }

    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json(null, 204);
    }
}

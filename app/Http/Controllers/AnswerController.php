<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnswerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Answers/Index', [
            'answers' => Answer::where('user_id', $user->id)->get(['id', 'title', 'profile', 'created_at']),
        ]);
    }

    public function store(Request $request)
    {
        $answer = Answer::create(
            $request->validate([
                'user_id' => 'required',
                'title' => 'required',
                'data' => 'required',
                'profile' => 'required'
            ])
        );

        return to_route('answers.show', $answer);
    }

    public function show(Answer $answer)
    {
        return Inertia::render('Answers/ShowAnswer', [
            'answer' => $answer,
        ]);
    }
}

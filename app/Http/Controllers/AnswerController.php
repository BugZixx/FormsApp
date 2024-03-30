<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnswerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Answers/Index', [
            'answers' => Answer::where('user_id', $user->id)->get('data'),
        ]);
    }

    public function store(Request $request)
    {
        $answer = Answer::create(
            $request->validate([
                'user_id' => 'required',
                'data' => 'required',
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

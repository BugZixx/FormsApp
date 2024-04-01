<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FormController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Forms/Index', [
            'forms' => Form::all(),
        ]);
    }

    public function show(Form $form)
    {
        return Inertia::render('Forms/AnsweringForm', [
            'form' => [
                'id' => $form->id,
                'name' => $form->name,
                'description' => $form->description,
                'fields' => $form->fields,
                'profiles' => $form->profiles
            ],
        ]);
    }
}

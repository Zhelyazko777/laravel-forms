<?php

namespace App\Http\Controllers;

use App\Forms\Dogs\StoreForm;
use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    public function create()
    {
        return view('dog.create', [
            'form' => \Form::create(StoreForm::class, new Dog)
        ]);
    }
}

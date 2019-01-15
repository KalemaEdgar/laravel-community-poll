<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Validator;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Question::get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request entries
        $rules = [
            'title' => 'required|max:30',
            'question' => 'required|max:50',
            'poll_id' => 'required|max:1'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $question = Question::create($request->all());
        return response()->json($question, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // Just use $question since its already type hinted to Question class
        // Laravel will display the details for that question
        return response()->json($question, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $rules = [
            'title' => 'max:30',
            'question' => 'max:50',
            'poll_id' => 'max:1'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) { return response()->json($validator->errors(), 400); }

        $question->update($request->all()); // This returns a boolean true/false but $question is updated in the background
        return response()->json($question, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        return response()->json($question->delete(), 204);
    }
}

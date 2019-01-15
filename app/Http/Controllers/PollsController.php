<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poll;
use Validator; // Validator is an alias to Illuminate\Support\Facades\Validator::class and is configured in the config/app.php file
use App\Http\Resources\Poll as PollResource;

class PollsController extends Controller
{

    public function index() 
    {
        // Return a response that is json formatted with a HTTP response code 200
        // and also get the Polls from the sqlite database we created.
        // return response()->json(Poll::get(), 200);
        return response()->json(Poll::paginate(1), 200);
    }
    
    public function show($id) 
    {
        $poll = Poll::with('questions')->findOrFail($id);        
        
        // Without using the laravel resource class to modify the response
        // return response()->json(Poll::findOrFail($id), 200);

        // // Using the laravel resource class to format the response back to the client
        // // This also gives you nested data as a response (A poll with all its questions)
        // $response = new PollResource($pollWithQuestions, 200);
        // return response()->json($response, 200);

        // Another alternative for responses to nested data is side loading.
        $response['poll'] = [
            'id' => $poll->id,
            'title' => $poll->title,
            'created_at' => $poll->created_at->diffForHumans(),
            'updated_at' => $poll->updated_at->diffForHumans(),
        ];
        $response['questions'] = $poll->questions;

        return response()->json($response, 200);
    }

    public function store(Request $request) 
    {
        // Validate the request parameters
        $rules = [
            'title' => 'required|max:30'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 400);
        }

        // Once the validation has been bypassed, we create the entity
        $poll = Poll::create($request->all());
        // 201 signifies that a resource has been created
        return response()->json($poll, 201);
    }

    public function update(Request $request, Poll $poll) 
    {
        // Validation of the input parameters
        $rules = ['title' => 'required|max:50'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        // Find the current poll using the id
        $poll->update($request->all());
        // Status code is 200 since we are only modifying the poll and not adding a new one.
        return response()->json($poll, 200);
    }

    public function destroy(Poll $poll) 
    {
        $poll->delete();
        // We return a null response after the delete action
        // 204 is the status code that tells us our resource was deleted
        return response()->json(null, 204);
        // return redirect()->route('errors', ['errorid' => 205]); // Test out custom errors (Redirect to a custom error handling method)
    }

    /** Use this function to setup custom error messages */
    public function errors() 
    // public function errors($errorId) 
    {
        // 501 is the HTTP code for when the server doesnot implement the code needed to handle the request
        return response()->json(['msg' => 'Payment is required'], 501);

        /** The below was for testing out how to handle multiple error codes  */
        // switch ($errorId) {
        //     case '501':
        //         $message = "Something has happened to the poll that the server cannot handle. Custom error";
        //         break;

        //     case '205':
        //         $message = "Poll has been deleted. Custom error";
        //         break;
            
        //     default:
        //         $message = "Unhandled error code";
        //         $errorId = 501;
        //         break;
        // }

        // return response()->json(['msg' => $message], $errorId);

    }

    /**
     * This function provides all the questions for a given poll
     * This uses the relationship "questions" configured in the Poll model
     *
     * @param Request $request
     * @param Poll $poll
     * @return json List of all questions for a given poll
     */
    public function questions(Request $request, Poll $poll) 
    {
        $questions = $poll->questions;
        return response()->json($questions, 200);
    }

}

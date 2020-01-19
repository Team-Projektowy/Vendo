<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Question;
use App\Http\Resources\Question as QuestionResource;
use App\Http\Requests;
use Illuminate\Http\Request;
// use DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::paginate(15);
        return QuestionResource::collection($questions);
    }

    public function indexByCategory($category)
    {
        $questions = Question::where('category', $category)->paginate(15);
        return QuestionResource::collection($questions);
    }

    public function indexBySearch($search)
    {
        $questions = Question::where('text', 'like', '%' . $search . '%')->paginate(15);
        return QuestionResource::collection($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question;

        $question->text = $request->input('text');
        $question->answerA = $request->input('answerA');
        $question->answerB = $request->input('answerB');
        $question->answerC = $request->input('answerC');
        $question->answerD = $request->input('answerD');
        $question->correctAnswer = $request->input('correctAnswer');
        $question->category = $request->input('category');
        $question->language = $request->input('language');
        $question->added_by_user = $request->input('added_by_user');

        if ($question->save()) {
            return new QuestionResource($question);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return new QuestionResource($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return view('questions/edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $question->text = $request->input('text');
        $question->answerA = $request->input('answerA');
        $question->answerB = $request->input('answerB');
        $question->answerC = $request->input('answerC');
        $question->answerD = $request->input('answerD');
        $question->correctAnswer = $request->input('correctAnswer');
        $question->category = $request->input('category');

        $question->save();

        return new QuestionResource($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if($question->delete()) {
            return new QuestionResource($question);
        }
    }

    public function createQuiz($category, $numberOfQuestions) {

        $questions = Question::where("category", $category)->get();
        $quiz = QuestionResource::collection($questions)->random($numberOfQuestions);
        return ["data" => $quiz];
    }

    public function checkQuiz(Request $request) {
        $input = $request->input();
        $questions = [];

        foreach ($input as $id => $answer) {
            $question = Question::findOrFail($id);
            $question->userAnswer = $answer;
            array_push($questions, $question->toDTO());
        }

        return ["data" => $questions];
    }
}

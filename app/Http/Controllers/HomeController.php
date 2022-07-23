<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function test()
    {
        return view('test');
    }

    public function getNextQuestion(): JsonResponse
    {
        $current_question = $this->getCurrentQuestion();
        $response = [
            'question_no' =>  $this->getQuizMeta()["index"] + 1,
            'question' => $current_question->question,
            'op1' => $current_question->answers->op1,
            'op2' => $current_question->answers->op2,
            'op3' => $current_question->answers->op3,
            'op4' => $current_question->answers->op4,
        ];

        return response()->json($response);
    }

    public function checkAns(Request $request): JsonResponse
    {
        $ans = $request->answer;
        if ($ans == $this->getCurrentQuestion()->answers->correct_ans)
            $this->setAns('correct');
        else
            $this->setAns('wrong');

        return $this->sendJsonResoponse();
    }

    public function skipQuestion(): JsonResponse
    {
        $this->setAns('skipped');
        return $this->sendJsonResoponse();
    }

    public function isQuizEnded()
    {
        return $this->getQuizMeta()["index"] >= 10;
    }


    private function getCurrentQuestion(){
        Cache::rememberForever('user_quiz_' . getUserID(), function () {
            return Question::getTenRandQuesWithAns();
        });
        Cache::rememberForever('user_result_' . getUserID(), function () {
            return [
                "index" => 0,
                "correct" => 0,
                "wrong" => 0,
                "skipped" => 0
            ];
        });

        $questions = Cache::get('user_quiz_'.getUserID());
        return $questions[$this->getQuizMeta()["index"]];
    }

    /**
     * This function will get cache result data.
     */

    private function getQuizMeta(){
        return Cache::get('user_result_'.getUserID());
    }

    /**
     * This function will set cache result data.
     */
    private function setQuizMeta($result){
        return Cache::forever('user_result_'.getUserID(),$result);
    }

    /**
     * This function will update result in cache
     * @return void
     */
    private function setAns($ans){

        $result = $this->getQuizMeta();
        switch ($ans)
        {
            case 'correct':
                $result['correct']++;
                break;
            case 'wrong':
                $result['wrong']++;
                break;
            case 'skipped':
                $result['skipped']++;
                break;
        }

        $result['index']++;
        $this->setQuizMeta($result);
    }

    /**
     * This function will return json respose to ajax calls
     * @return JsonResponse
     */
    public function sendJsonResoponse(): JsonResponse
    {
        if ($this->isQuizEnded()) {
            $this->saveResults();
            return response()->json(['success' => true, 'is_ended' => true, 'meta' => $this->getQuizMeta()]);
        }

        return response()->json(['success' => true, 'is_ended' => false, 'meta' => $this->getQuizMeta()]);
    }

    /**
     * Save final results in database.
     * @return void
     */
    private function saveResults()
    {
        $result = $this->getQuizMeta();
        unset($result['index']);
        $result['user_id'] = getUserID();
        Result::create($result);
        $this->flushCache();
    }

    private function flushCache(){
        Cache::forget('user_quiz_'.getUserID());
        Cache::forget('user_result_'.getUserID());
    }
}

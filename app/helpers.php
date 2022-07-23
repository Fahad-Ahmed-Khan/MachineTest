<?php
if (! function_exists('setUser')) {
    function setUserID($user_id){
        session(['__logged_in_user_id__' => $user_id]);
        session()->save();
    }
}
if (! function_exists('getUser')) {
    function getUserID(){
        return session()->get('__logged_in_user_id__');
    }
}
if (! function_exists('unsetUser')) {
    function unsetUserID(){
        session()->forget('__logged_in_user_id__');
    }
}
if (! function_exists('isUserExist')) {
    function isUserExist(): bool
    {
        return session()->has('__logged_in_user_id__');
    }
}

if (! function_exists('getAttemptedQuestions')) {
    function getAttemptedQuestions(){
        if(session()->has('_attempted_questions_'.getUserID())){
            return  session("_attempted_questions_".getUserID());
        }
        return [];
    }
}

if (! function_exists('getAttemptedQuestions')) {

    function setAttemptedQuestions($question_id)
    {
        if (session()->has('_attempted_questions_'.getUserID())) {
            session()->push('_attempted_questions_'.getUserID(), $question_id);
        } else {
            session("_attempted_questions_".getUserID(), [$question_id]);
        }
    }
}

if (! function_exists('countAttemptedQuestions')) {

    function countAttemptedQuestions(): int
    {
        return count(getAttemptedQuestions());
    }
}

if (! function_exists('clearAttemptedQuestions')) {

    function clearAttemptedQuestions()
    {
        session()->forget('_attempted_questions_'.getUserID());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Onboard\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class QuestionController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markConnected(Request $request)
    {
        $this->validate($request, [
            'service' => 'in:' . implode(',', array_pluck(config('onboard.services'), 'name'))
        ]);

        $answer = Answer::query()->firstOrCreate([
                        'type'          => $request->input('service'),
                        'user_id'       => Auth::id(),
                    ]);

        $answer->update([
           'is_reviewed'    => false,
           'is_complete'    => false,
        ]);

        return redirect()->back()->with('status', $request->input('service') . " connection pending review.");
    }
    public function updateQuestion(Request $request)
    {
        $question = Question::where('id', $request['question']['id'])->first();
        $question['question'] = $request['question']['question'];
        $question->save();

        return response('Update Successful.', 200);
    }
    public function deleteQuestion(Request $request)
    {
        $question = Question::where('id', $request['question']['id'])->first();
        $answers = $question->answers()->get();
        foreach ($answers as $answer) {
            $answer->delete();
        }
        $question->delete();

        return response('Update Successful.', 200);
    }
}

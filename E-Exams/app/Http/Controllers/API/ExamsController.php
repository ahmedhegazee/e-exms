<?php

namespace App\Http\Controllers\API;

use App\ExamAnswer;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Http\Resources\ExamStructureResource;
use App\Http\Resources\StudentResultResource;
use App\Subject\Exam;
use App\Subject\ExamResult;
use App\Subject\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Subject $subject
     * @return AnonymousResourceCollection
     */
    public function index(Subject $subject)
    {
        return ExamResource::collection($subject->exams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function store(Request $request, Subject $subject)
    {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $exam = $subject->exams()->create($request->only('start_time', 'end_time', 'exam_time', 'marks', 'exam_type'));
        collect($request->get('chapters'))->each(function ($structure) use ($exam) {
            $exam->structures()->create([
                'chapter_id' => $structure['id'],
                'category' => $structure['category'],
                'questions_count' => $structure['count'],
            ]);
        });
        return ExamStructureResource::collection($exam->structures);
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @param Exam $exam
     * @return AnonymousResourceCollection
     */
    public function show(Subject $subject, Exam $exam)
    {
        return ExamStructureResource::collection($exam->structures);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subject $subject
     * @param Exam $exam
     * @return void
     */
    public function update(Request $request, Subject $subject, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Exam $exam
     * @return Response
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function generateCode(Exam $exam)
    {
        if (!$exam->examined) {
            if (is_null($exam->exam_code)) {
                $randomCode = Str::random(8);
                $exam->update(['exam_code' => $randomCode]);
                return \response()->json(['success' => true, 'code' => $randomCode]);
            } else {
                return \response()->json(['success' => false, 'message' => 'this exam has code', 'code' => $exam->exam_code]);
            }

        } else {
            return \response()->json(['success' => false, 'message' => 'this exam is examined']);
        }

    }

    public function getAnalysisOfStudentAnswers(Subject $subject, Exam $exam)
    {
        $succeededStudents = ExamResult::filterSubject($subject->id)->filterExam($exam->id)->succeeded()->get()->count();
        $failedStudents = ExamResult::filterSubject($subject->id)->filterExam($exam->id)->failed()->get()->count();
      $questionsAnalysis=$exam->questions->map(function($question) use ($exam) {
        $wrongAnswers=  ExamAnswer::filterExam($exam->id)->filterQuestion($question->id)->wrong()->get()->count();
        $correctAnswers=  ExamAnswer::filterExam($exam->id)->filterQuestion($question->id)->correct()->get()->count();
        $options=$question->options->map(function($option) use ($exam) {
            $count =ExamAnswer::filterExam($exam->id)->filterQuestionOption($option->id)->get()->count();
            return [
              'option_id'=>$option->id,
                'option_content'=>$option->option_content,
              'count'=>$count,
            ];

        });
        return [
            'id'=>$question->id,
            'question_content'=>$question->question_content,
            'failed_students'=>$wrongAnswers,
            'succeeded_students'=>$correctAnswers,
            'options'=>$options->toArray()
        ];
      });
//      dd();
      return response()->json(['succeeded_students'=>$succeededStudents,'failed_students'=>$failedStudents,'questions_analysis'=>$questionsAnalysis->toArray()]);
//      dd($questionsAnalysis);
    }

    public function getStudentResults(Subject $subject,Exam $exam)
    {
        $results =ExamResult::filterSubject($subject->id)->filterExam($exam->id)->get();
//        dd($results);
        return StudentResultResource::collection($results);
    }

    public function validator($data)
    {
        $rules = [
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'exam_time' => 'required|string|regex:/^[0][0-8][:][0-5][0-9]$/', //the time must be hh:mm
            'marks' => 'required|numeric',
            'exam_type' => 'required|numeric|min:1|max:3',
            'chapters.*.id' => 'required|numeric',
            'chapters.*.count' => 'required|numeric',
            'chapters.*.category' => 'required|string|regex:/^[A-C]{1}$/|min:1|max:1',
        ];
        return Validator::make($data, $rules);
    }
}

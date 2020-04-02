<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResultResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\StudentSubjectResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TrainingExamsAnswersResource;
use App\Level;
use App\StudyingPlan;
use App\Subject\Subject;
use App\TrainingExam\TrainingExamAnswers;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SubjectResource::collection(Subject::all());
    }

    /**
     * @param Subject $subject
     */
    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return SubjectResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $level = Level::findOrFail($request->get('level_id'));
        $count = $level->departments()->hasDept($request->get('department_id'))->count();
        if ($count > 0) {
            $check = Subject::create($request->all());

//        $check= auth()->user()->getProfessor()->subjects()->create($request->all());
//        return response()->json(['success'=>$check]);
            return new SubjectResource($check);
        } else {
            return response()->json(['success' => false, 'errors' => 'this department is not in this level']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subject $subject
     * @return SubjectResource|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Subject $subject)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $check = $subject->update($request->all());
        return new SubjectResource($check);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }

    public function getProfessorSubjects()
    {
        return SubjectResource::collection(auth()->user()->professor->subjects);
    }

    public function getStudentSubjects()
    {
        $subjects = auth()->user()->student->getSubjects();
        return StudentSubjectResource::collection($subjects);
    }

    public function getWrongAnswers(Request $request, Subject $subject)
    {
        //type =>1 for MCQ , 2 for T|F
        $validator = $this->validateFilters($request->all());
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);
        if ($request->has('type')) {
            $type = intval($request->get('type'));
            $page = $request->has('page') ? intval($request->get('page')) : 1;
            $perPage = 20;
            $index = ($page - 1) * $perPage;
//            dd($chapter->questions()->questionType($type)->paginate(20));
            $examIds = auth()->user()->student->trainingExams()->subject($subject->id)->get()->pluck('id');
            $answers = TrainingExamAnswers::exams($examIds)->wrongAnswers()->get()
                ->filter(function ($answer) use ($type) {
                    if ($answer->question->type->id == $type)
                        return $answer;
                });
            $pages = intval(ceil($answers->count() / $perPage));
            $answers = $answers->slice($index, $perPage);
            if ($answers->count() == 0)
                return response()->json(['error' => 'please wrote correct page number']);
            return response()->json(['pages count' => $pages, 'answers' => TrainingExamsAnswersResource::collection($answers)->jsonSerialize()]);
        }
    }

    public function getSubjectExamsResults(Request $request, Subject $subject)
    {
        //1 for midterm , 2 for quiz , 3 for final

        $validator = $this->validateExamsFilter($request->all());
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);
        if ($request->has('type')) {
            $type = intval($request->get('type'));
            $page = $request->has('page') ? intval($request->get('page')) : 1;
            $perPage = 20;
            $index = ($page - 1) * $perPage;
            //exams in particular subject with particular type .
            $examIds = $subject->exams()->type($type)->get()->pluck(['id']);
            if($examIds->count()==0)
                return \response()->json(['error'=>'there is no exams with this type in this subject']);
            $examIds = $examIds->toArray();
            $student = auth()->user()->student;
            $results = $student->examResults()->exams($examIds)->get();
            if($results->count()==0)
                return \response()->json(['error'=>'the student did not solve the exams in this subject']);

            $pages = intval(ceil($results->count() / $perPage));
            $results = $results->slice($index, $perPage);
            if ($results->count() == 0)
                return response()->json(['error' => 'please wrote correct page number']);
            return response()->json(['pages count' => $pages, 'results' => ExamResultResource::collection($results)->jsonSerialize()]);

        }
    }

    public
    function validator($data)
    {
        $rules = [
            'subject_name' => 'required|string|regex:/^[A-Za-z0-9 ]+$/|min:5|max:200',
            'subject_code' => 'required|string|regex:/^[A-Za-z0-9 ]+$/|unique:subjects|min:3|max:10',
            'level_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'term' => 'required|numeric',
            'professor_id' => 'required|numeric',
            'credit_hours' => 'required|numeric|min:1|max:20|regex:/^[1-9]{1,2}$/'
        ];

        return Validator::make($data, $rules);
    }

    public function validateFilters($data)
    {
        $rules = [
            'type' => 'required|numeric|min:1|max:2',
            'page' => 'sometimes|numeric'
        ];

        return Validator::make($data, $rules);
    }

    public function validateExamsFilter($data)
    {
        $rules = [
            'type' => 'required|numeric|min:1|max:3',
            'page' => 'sometimes|numeric'
        ];
        return Validator::make($data, $rules);
    }
}


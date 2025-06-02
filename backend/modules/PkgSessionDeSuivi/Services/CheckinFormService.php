<?php

namespace Modules\PkgSessionDeSuivi\Services;

use Modules\PkgSessionDeSuivi\Domain\Interfaces\CheckinFormRepositoryInterface;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CheckinFormService implements CheckinFormRepositoryInterface
{
    protected $checkinFormRepository;
    protected $questionRepository;
    public function __construct(CheckinFormRepositoryInterface $checkinFormRepository       , QuestionRepositoryInterface $questionRepository)
    {
        $this->checkinFormRepository = $checkinFormRepository;
        $this->questionRepository = $questionRepository;
    }
    public function getAll()
    {
        return $this->checkinFormRepository->getAll();
    }
   
    public function createFormWithQuestions($data)
    {
        return DB::transaction(function () use ($data) {
            $form = $this->checkinFormRepository->createFormWithQuestions([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'created_by' => $data['created_by'],
            ]);
    
            foreach ($data['questions'] as $question) {
                $this->questionRepository->create([
                    'checkin_form_id' => $form->id,
                    'question_text' => $question['question_text'],
                    'question_type' => $question['question_type'],
                ]);
            }
    
            return $form->load('questions');
        });
    }

    public function getFormById($id){
        return $this->checkinFormRepository->getFormById($id);
    }
    public function deleteFormQuestions($id){
        return $this->checkinFormRepository->deleteFormQuestions($id);
    }
}

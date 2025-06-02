<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;

use Modules\PkgSessionDeSuivi\Domain\Entities\Question;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    protected $questionRepository;
    public function __construct(Question $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    public function getAll()
    {
        return $this->questionRepository->all();
    }
    public function create($data)
    {
        return $this->questionRepository->create($data);
    }
}

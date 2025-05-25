<?php

namespace Modules\PkgEntretienIndividuel\Services;

use Modules\PkgEntretienIndividuel\Domain\Interfaces\IQuestion;

class QuestionService
{
    protected $questionRepository;
    
    public function __construct(IQuestion $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    
    public function getAll() 
    {
        return $this->questionRepository->all();
    }
    public function find($id)
    {
        return $this->questionRepository->find($id);
    }
    public function create(array $data )
    {
        return $this->questionRepository->create($data);
    }
    public function update($id, array $data)
    {
        return $this->questionRepository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->questionRepository->delete($id);
    }
}
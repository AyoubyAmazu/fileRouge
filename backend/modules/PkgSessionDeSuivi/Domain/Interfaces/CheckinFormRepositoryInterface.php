<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface CheckinFormRepositoryInterface
{
    public function getAll();
    public function createFormWithQuestions($data);
    public function deleteFormQuestions($id);
    public function getFormById($id);
 
}

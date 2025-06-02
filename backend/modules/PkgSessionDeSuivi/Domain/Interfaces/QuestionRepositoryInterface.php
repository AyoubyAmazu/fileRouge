<?php

namespace Modules\PkgSessionDeSuivi\Domain\Interfaces;

interface QuestionRepositoryInterface
{
    public function getAll();
    public function create($data);
}

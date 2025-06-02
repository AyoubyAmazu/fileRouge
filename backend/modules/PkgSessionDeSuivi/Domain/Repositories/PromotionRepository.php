<?php

namespace Modules\PkgSessionDeSuivi\Domain\Repositories;
use Modules\PkgSessionDeSuivi\Domain\Interfaces\PromotionRepositoryInterface;
use Modules\PkgApprenant\Models\Promotion;

class PromotionRepository implements PromotionRepositoryInterface
{
    protected $promotion;
    
    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }
    public function getAll()
    {
        return $this->promotion->all();
    }
}

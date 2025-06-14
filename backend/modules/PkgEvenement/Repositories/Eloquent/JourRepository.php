<?php
namespace Modules\pkgEvenement\Repositories\Eloquent;

use Modules\pkgEvenement\Models\EvenementJours;
use Modules\pkgEvenement\Repositories\Eloquent\BaseReporistory;
class JourRepository extends BaseReporistory
{
    protected $filterBy = 'jour';
    protected $relations = ['evenement'];

    public function __construct(EvenementJours $model)
    {
        parent::__construct($model);
    }
    public function store(array $data)
    {

        return $this->model->create($data);
    }



}





?>

<?php

namespace Modules\pkgEvenement\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\pkgEvenement\Repositories\Interfaces\Icrud;

class BaseReporistory implements Icrud
{
    protected Model $model;
    protected $filterBy  ;
    protected $relations=[] ;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(?int $year )
    {

        if($year && $this->relations)
        {
            return $this->model->whereRelation($this->relations[0], $this->filterBy, $year)->with($this->relations)->get();
        }
        else if($this->relations)
        {
             return $this->model->with($this->relations)->get();
        }else if ($year) {
            return $this->model->whereYear($this->filterBy, $year)->get();
        }
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function destroy(int $id)
    {
         $this->model->destroy($id);
    }



}


<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CrudShow
{
    abstract public function getModel(): string;

    public ?Model $model = null;

    public function mount(...$params): void
    {
        $modelClass = $this->getModel();

        $id = null;

        if(count($params) > 0) {
            $id = $params[0];
        }

        if(!$id) {
            foreach($params as $param) {
                if($param instanceof Model && $param instanceof $modelClass) {
                    $id = $param;
                    break;
                }
            }
        }

        if ($id) {
            if($id instanceof Model) {
                $this->model = $id;
            } else {
                $this->model = $modelClass::findOrFail($id);
            }
        }

        if (!$this->model) {
            abort(404);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;


    public function scureDelete(String ...$relations)
    {
        $hasRelation = false;
        foreach ($relations as $relation) {
            if ($this->$relation()->withTrashed()->count()) {
                $hasRelation = true;
                break;
            }
        }

        if ($hasRelation) {
            $this->delete();
        } else {
            $this->forceDelete();
        }
    }

    public function hasRelations(String ...$relations)
    {
        foreach ($relations as $relation) {
            if ($this->$relation()->count()) {
                return true;
            }
        }

        return false;
    }
}

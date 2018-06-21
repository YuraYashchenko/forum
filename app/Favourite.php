<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use RecordsActivity;

    protected $fillable = ['user_id'];

    public function favouritable()
    {
        return $this->morphTo();
    }
}

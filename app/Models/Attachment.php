<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    //
    
    
    use SoftDeletes;
    
    protected $fillable = ['article_id', 'name' ,'status'];
    protected $dates = ['deleted_at'];
    
    public function article()
    {
        return $this->belongsTo('App\Models\Article','article_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    
    use SoftDeletes;
    
    protected $fillable = ['title', 'content','done_at','status'];
    protected $dates = ['deleted_at'];
    protected $with = array('attachment');
    //
    /**
     * Get the comments for the blog post.
     */
    public function attachment()
    {
        return $this->hasMany('App\Models\Attachment','article_id', 'id');
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Support\Carbon;

class ArticleTest extends TestCase
{
    
    protected $num = 10;
    public function setUp(): void
    {
        parent::setUp();
        
        $this->model = Article::class;
        $this->where = array(  'title'  => "create - ".Carbon::now());
        $this->data = array(
            'title' => $this->where['title'],
            'content'  => 'test - content ',
            'done_at' => Carbon::now(),
        );
        $this->update = array('title' => "update - ".Carbon::now());
        
        $this->moredata = array();
        for ($i = 1; $i <= $this->num; $i ++) {
            $this->moredata[$i] = array(
                'title' => $this->where['title'],
                'content'  => 'test - content ' . $i,
                'done_at' => Carbon::now(),
            );
        }
    }
}

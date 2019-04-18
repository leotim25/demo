<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Attachment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class AttachmentTest extends TestCase
{
    protected $num = 10;
    public function setUp(): void
    {
        parent::setUp();
        
        $this->model = Attachment::class;
        $this->where = array('name'  => "create - ".Carbon::now());
        $this->data = array(
            'article_id' => 1,
            'name'  => "create - ".Carbon::now(),
        );
        $this->update = array('name' => "update - ".Carbon::now());
        
        $this->moredata = array();
        for ($i = 1; $i <= $this->num; $i ++) {
            $this->moredata[$i] = array(
                'article_id' => $i,
                'name'  => "create - ".Carbon::now(),
            );
        }
    }
}

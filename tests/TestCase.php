<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected $num = 10;
    protected $model;
    protected $update = array();
    protected $where = array();
    protected $data =array();
    protected $moredata =array();
    
    public function setUp(): void
    {
        parent::setUp();
        
    }
    /**
     * model confirm null.
     *
     * @return void
     */
    public function testEmptyResult()
    {
        $res = $this->model::all();
        $this->assertInstanceOf(Collection::class, $res);
        $this->assertEquals(0, count($res));
    }
    /**
     * model creat data.
     *
     * @return void
     */
    public function testCreateData()
    {
        for ($i = 1; $i <= $this->num; $i ++) {
            $this->model::create($this->moredata[$i]);
        }
        $res = $this->model::where($this->where)->get();
        $this->assertEquals($this->num, count($res));
    }
    /**
     * model show data.
     *
     * @return void
     */
    public function testOneData(){
        
        $this->model::create($this->data);
        $res = $this->model::where($this->where)->get();
        $this->assertEquals(1, count($res));
    }
    /**
     * model edit data.
     *
     * @return void
     */
    public function testEditOneData(){
        
        $this->model::create($this->data);
        $res = $this->model::where($this->where)->update($this->update);
        $this->assertEquals(1, $res);
    }
}

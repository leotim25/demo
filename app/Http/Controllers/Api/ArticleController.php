<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected $artcleRep;
    
    
    function __construct(ArticleRepository $artcleRep){
        $this->middleware('jwt.auth', ['except' => ['index','show']]);
        $this->artcleRep = $artcleRep;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $res = $this->artcleRep->showAll();
        if($res){
            return response()->success($res);
        }
        return response()->error('artcle list is null');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $all = $request->only(['title', 'content','attachments']);
        $validator = Validator::make($all, [
            'title' => 'required|max:255',
            'content' => 'required|string',
            'attachments.*'=>'required |mimes:png,jpeg,jpg,gif| max:1000',
            [
                'attachments.*.required' => 'Please upload an image',
                'attachments.*.mimes' => 'Only png,jpeg,jpg,gif are allowed',
                'attachments.*.max' => 'Maximum allowed size for an image is 10MB',
            ]
        ]);
        if($validator->fails()){
            return response()->error($validator->errors());
        }
        $res = $this->artcleRep->create($all);
        if($res){
            return response()->success($res);
        }
        return response()->error('error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $res = $this->artcleRep->show($id);
        if($res){
            return response()->success($res);
        }
        return response()->error('artcle is null');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $all = $request->only(['title', 'content']);
        $validator = Validator::make($all, [
            'title' => 'max:255',
            'content' => 'string',
        ]);
        if($validator->fails()){
            return response()->error($validator->errors());
        }
        $res = $this->artcleRep->update(['id'=>$id],$all);
        if($res){
            return response()->success();
        }
        return response()->error('error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $res = $this->artcleRep->delete($id);
        if($res){
            return response()->success();
        }
        return response()->error('artcle '.$id.' not delete');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        //
        $res = $this->artcleRep->deleteAll();
        if($res){
            return response()->success();
        }
        return response()->error('artcle all delete');
    }
}

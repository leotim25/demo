<?php
namespace App\Repositories;

use App\Models\Article;
use App\Models\Attachment;
use Illuminate\Support\Carbon;

class ArticleRepository
{

    protected $article;

    protected $attachment;

    function __construct(Article $article, Attachment $attachment)
    {
        $this->article = $article;
        $this->attachment = $attachment;
    }

    public function show($id)
    {
        $res = $this->article->where('id', $id)->get();
        if (! $res->isEmpty()) {
            return $res;
        }
        return false;
    }

    public function showAll()
    {
        $res = $this->article->get();
        if (! $res->isEmpty()) {
            return $res;
        }
        return false;
    }

    public function update($where, $input)
    {
        $input['done_at'] = Carbon::now();
        $res = $this->article->where($where)->update($input);
        if ($res) {
            return true;
        }
        return false;
    }

    public function create($input)
    {
        $article = $this->article::create($input);
        $articleAttachments = array();
        if ($article) {
            $attachments = $input['attachments'];
            if ($attachments) {
                foreach ($attachments as $k => $photo) {
                    $filename = $photo->store('photos');
                    $articleAttachments[$k] = $this->attachment->create([
                        'article_id' => $article->id,
                        'name' => $filename
                    ]);
                    if (! $articleAttachments[$k]) {
                        unset($articleAttachments[$k]);
                    }
                }
            }
            if ($article && (count($articleAttachments) == count(empty($attachments) ? array() : $attachments))) {
                $res = $this->article->where([
                    'id' => $article->id
                ])->update([
                    'done_at' => Carbon::now()
                ]);
                if ($res) {
                    return $article->id;
                }
                return false;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $res = $this->article->where('id', $id)->delete();
        if ($res) {
            return true;
        }
        return false;
    }
    public function deleteAll()
    {
        $res = $this->article->query()->delete();
        if ($res) {
            return true;
        }
        return false;
    }
}
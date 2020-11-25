<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Reply $reply, Topic $topic)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if($topic->id != $reply->topic_id){
            abort(404,'删除失败');
        }
        $this->authorize('destroy',$reply);
        $reply->delete();
        return response(null,204);
    }
}

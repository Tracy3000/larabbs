<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\User;
use App\Http\Queries\TopicQuery;
class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update',$topic);//策略判断此话题是否为当前用户的

        $topic->update($request->all());

        return new TopicResource($topic);
    }

    public function destroy(TopicRequest $request, Topic $topic)
    {
        $this->authorize('destroy',$topic);
        $topic->delete();
        return response(null,204);
    }

    public function index(TopicRequest $request, TopicQuery $query)
    {
        $topics = $query
            ->paginate();

        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user,TopicQuery $query)
    {
        $topics = $query
            ->where('user_id',$user->id)
            ->paginate();

        return TopicResource::collection($topics);
    }

    public function show($topicId, TopicQuery $query)
    {
        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }
}

<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
	    $topics = $topic->withOrder($request->order)
            ->with('user','category')//防止N+1问题
            ->paginate(20);
//        $topics = Topic::with('user', 'category')->paginate(30);//关联属性，预加载提高性能
        return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
	    $topic->fill($request->all());//fill 方法会将传参的键值数组填充到模型的属性中
	    $topic->user_id = Auth::id();
	    $topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);//授权策略
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());
		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化状态
        $data = [
            'success'   => false,
            'msg'       => '上传失败',
            'file_path' => ''
        ];
        if($file = $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($file,'topics',Auth::id(),1024);
            if($result){
                $data['file_path'] = $result['path'];
                $data['success'] = true;
                $date['msg'] = '上传成功';
            }
        }
        return $data;
	}
}
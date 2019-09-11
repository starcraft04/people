<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Entrust;

class CommentController extends Controller {


    public function show($id)
    {
        $comment = Comment::find($id);
        if ($comment && $comment->user_id == Auth::user()->id || Auth::user()->id == 1) {
            return json_encode($comment);
        } else {
            return 'error';
        }
    }
    public function commentList(Request $request)
    {
        $inputs = $request->all();
        //dd($inputs);
        return Comment::whereIn('project_id', $inputs['project_ids'])->with('user_summary')->orderBy('created_at','desc')->get();
    }

    public function commentInsert(Request $request)
	{
        $inputs = $request->all();
        $result = new \stdClass();
        $insert_result = Comment::create($inputs);
        if ($insert_result != null) {
            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Record added successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'Record issue';
        }
        
        return json_encode($result);
    }

    public function getList($project_id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();

        $comments = Comment::where('project_id','=',$project_id)->orderBy('updated_at','desc')->get();
        $num_of_comments = count($comments);
        $result->num_of_comments = $num_of_comments;
        $result->list = [];

        $i = 0;
        foreach ($comments as $comment) {
            $result->list[$i] = new \stdClass();
            if ($comment->user_id == Auth::user()->id || Auth::user()->id == 1) {
                $result->list[$i]->id = $comment->id;
            } else {
                $result->list[$i]->id = -1;
            }
            $result->list[$i]->comment = $comment->comment;
            $result->list[$i]->time = $comment->updated_at->diffForHumans();
            $result->list[$i]->user_name = $comment->user->name;
            $i++;
        }

        return json_encode($result);
    }

    public function edit(Request $request, $id)
    {
        $result = new \stdClass();
        $inputs = $request->all();
        //dd($inputs);
        $comment = Comment::find($id);
        if ($comment->user_id == Auth::user()->id || Entrust::can('comment-all')) {
            $comment->comment = $inputs['comment'];
            $comment->save();
            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Message deleted successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'Message cannot be edited by you';
        }
        return json_encode($result);
    }

    public function delete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $comment = Comment::find($id);
        if ($comment->user_id == Auth::user()->id || Entrust::can('comment-all')) {
            Comment::destroy($id);
            $result->result = 'success';
            $result->box_type = 'success';
            $result->message_type = 'success';
            $result->msg = 'Message deleted successfully';
        } else {
            $result->result = 'error';
            $result->box_type = 'danger';
            $result->message_type = 'error';
            $result->msg = 'Message cannot be deleted by you';
        }
        return json_encode($result);
    }

}

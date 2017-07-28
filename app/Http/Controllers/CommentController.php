<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests;

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
        if ($comment->user_id == Auth::user()->id || Auth::user()->id == 1) {
            $comment->comment = $inputs['comment'];
            $comment->save();
            $result->result = 'success';
            $result->msg = 'Message deleted successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'Message cannot be deleted by you';
        }
        return json_encode($result);
    }

    public function delete($id)
    {
        // When using stdClass(), we need to prepend with \ so that Laravel won't get confused...
        $result = new \stdClass();
        $comment = Comment::find($id);
        if ($comment->user_id == Auth::user()->id || Auth::user()->id == 1) {
            Comment::destroy($id);
            $result->result = 'success';
            $result->msg = 'Message deleted successfully';
        } else {
            $result->result = 'error';
            $result->msg = 'Message cannot be deleted by you';
        }
        return json_encode($result);
    }

}

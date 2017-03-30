<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests;
use App\Tasklist;
use App\Comment;

class CommentsController extends Controller
{
    public function index($tasklist_id) 
    {
        return Comment::where('tasklist_id', $tasklist_id)->get();
    }

    public function save($tasklist_id, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        
        $tasklist = Tasklist::find($tasklist_id);
        $comment = $tasklist->addComment($request->body);

        if($request->wantsJson()) {
            return response(['Kommentti lisätty.', $comment], 200);
        }

        return back()->with('status', 'Kommentti lisätty');
    }

    public function delete($id, Request $request)
    {
        if(Gate::denies('manage-comments', $id)) {
            $message = 'Sinulla ei ole riittäviä oikeuksia.';
            if($request->wantsJson()) {
                return response($message, 403);
            }
            return back()
                ->with('status', $message);
        }

        Comment::destroy($id);

        $message = 'Kommentti poistettu.';
        if($request->wantsJson()) {
            return response($message, 200);
        }

        return back()
            ->with('status', $message);
    }


}

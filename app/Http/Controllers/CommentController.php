<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ad;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {       
        $comment = $this->validate(request(), [
           'text' => 'required|max:200',
           'user_id' => 'required', 
        ]);
           $data   = $request->all();
           Comment::create($data);

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        if(Auth::user()->blacklist == 1) {
          abort(404, 'Ошибка! Вы в черном списке.');
        }
        $comment = Comment::find($id);
        $ad_id  = $comment->ad_id;
        $comment->delete();
        
        return redirect('/ads/'.$ad_id);
    }
}

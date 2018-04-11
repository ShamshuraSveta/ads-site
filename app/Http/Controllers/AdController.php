<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Ad;
use App\Comment;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::user() ){
            $allAds = Ad::where('id','>','0')
                    ->orderBy('id','desc')
                    ->paginate(12);
        }else{
            $allAds = Ad::where('id','>','0')
                   ->with('user') 
                   ->where('published', 1)
                   ->orderBy('id','desc')
                   ->paginate(12);
        }
        return view('ads.index', ['allAds' => $allAds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() and Auth::user()->blacklist == 1) {
            abort(404, 'Ошибка! Вы в черном списке.');
       }
        if(!Auth::check()) {
            return view('auth.login');
        }
        return view('ads.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ad = $this->validate(request(), [
           'title' => 'required|max:200',
           'text' => 'required|max:400',
           'user_id' => 'required', 
        ]);
        $photo = 'images/no_photo.png';
        if( $request->hasFile('photo') ) {
            $img = $request->file('photo');
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $photo = $img->move('images', $filename);
        }   
           $data   = $request->all();
           $data['photo']  = $photo;
        Ad::create($data);

        return redirect('/ads');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Ad::where('id', $id)
             ->with('user')
             ->first();
        $comments = Comment::where('ad_id', $id)
            ->with('user')
            ->orderBy('created_at','desc')
            ->paginate(10);
            
        return view('ads.ad', ['ad' => $ad, 'comments' => $comments]); 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->blacklist == 1) {
           abort(404, 'Ошибка! Вы в черном списке.');
        }
        $ad = Ad::find($id);
        
        return view('ads.edit', ['ad' => $ad]);
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
        $ad = $this->validate(request(), [
           'title' => 'required|max:200',
           'text' => 'required|max:200',
           'user_id' => 'required', 
        ]);
        $ad = Ad::find($id);
        $photo = 'images/no_photo.png';
        if( $request->hasFile('photo') ) {
            $img = $request->file('photo');
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $photo = $img->move('images', $filename);
        }   
            $data = $request->all();
            $data['photo']  = $photo;
            $ad->update($data);

        return redirect('/ads');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->blacklist == 1) {
          abort(404, 'Ошибка! Вы в черном списке.');
        }
        $ad = Ad::find($id);
        $ad->delete();
        
        return redirect('/ads');
    }
}

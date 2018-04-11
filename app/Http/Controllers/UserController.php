<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','>','0')
                    ->orderBy('id','desc')
                    ->paginate(10);

        return view('users.index', ['users' => $users]);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {    
        if((Auth::user()->role_id == 1 or ($id == Auth::user()->id))) {
            $user = User::find($user_id);
            $allAds = Ad::where('user_id', $user_id)
                    //->get()
                    ->paginate(5);

            return view('users.profile', ['allAds' => $allAds, 'user' => $user]);
        }
        abort(404, 'Ошибка!');;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', ['user' => $user]);
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
        $user = $this->validate(request(), [
            'name' => 'required|max:200',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ]);
        $user = User::find($id);
        $data   = $request->all();
        $user->update($data);

        return redirect('/user');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
       
        return redirect('/user');
    }
}

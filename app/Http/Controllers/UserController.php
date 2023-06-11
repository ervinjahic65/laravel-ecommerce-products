<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('check');
    // }

    public function index()
    {
        $users = UserModel::getUsers();
        return view('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('user.insert-edit');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'=> 'required',
            'confirm_password' => 'required|same:password',

        ]);
        $data = $request->except('_token','confirm_password');
        $data['password'] = \Hash::make($request->password);
        $data['is_admin'] = 0; // Set the default value for is_admin field

        $insertResult = DB::table('users')->insert($data);

        if($insertResult){
            return redirect('/login')->with('status', 'Korisnik kreiran!');
        } else{
            return redirect('signup')->with('status', 'Greška, pokušajte ponovo');;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        return view('users.insert-edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = UserModel::deleteUser($id);
        if($result){
            return redirect('users')->with('status', 'Korisnik ažuriran!');
        } else{
            return view('edit',$id)->with('status', 'Greška, pokušajte ponovo');;
        }
    }
}

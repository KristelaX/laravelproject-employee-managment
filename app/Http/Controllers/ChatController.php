<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departments;
use App\User;
use App\Chat;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $id=auth()->id();
         $user=DB::table('users')->where('id', '=', $id)->get();

        $us = User::find(auth()->id());
         $mesazhe=DB::table('chats')->select('sender', 'created_at', 'msg')
            ->orderBy('created_at', 'desc')->limit(5)->get();
         if($us->isAdmin()) {
             return view("chat", array('chatuser' => $user), array('mesazhe' => $mesazhe));
         }
         else{
             return view("userchat", array('chatuser' => $user), array('mesazhe' => $mesazhe));
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendMessage(Request $request)
    {
        $id = $request->input('id');
        $username= $request->input('name');
        $text=$request->input('msg');
        $chatMessage = new Chat();
        $chatMessage->sender = $username;
        $chatMessage->msg = $text;
        $chatMessage->sender_id = $id;
        $chatMessage->save();
    }



    public function retrieveChatMessages(Request $request)
    {
        $id = $request->input('id');

        $message =Chat::where('sender_id', '!=', $id)->where('read', '=', false)->first();

        if (count($message) > 0)
        {

           echo json_encode($message);
            $message->read = true;
            $message->save();
        }
    }




}

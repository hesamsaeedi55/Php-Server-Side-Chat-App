<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\Users;
use Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'user_id' => 'required'
        ]);

        $user = $request->user();
        $otherPerson = User::find($request->user_id);

        $chat = Chat::conversations()->between($user, $otherPerson);

        if(!isset($chat)) {
            $chat = Chat::makeDirect()->createConversation([$user,$otherPerson]);

        }

        return $chat;
    }

    public function index(Request $request) {

        return Chat::conversations()->setParticipant($request->user())->isDirect()->get();

        
    }

    public function sendMessage(Request $request, $id) {

        $request->validate([
            'message' => 'required'
        ]);

        $chat = Chat::conversations()->getById($id);

        $message = Chat::message($request->message)
            ->from($request->user())
            ->to($chat)
            ->send();

            return $message;
        
    }

    public function show(Request $request, $id) {
        
        $chat = Chat::conversations()->getById($id);

        $messages = Chat::conversation($chat)->setParticipant($request->user())->getMessages();

        return $messages;


    }


    public function getUsers(Request $request) {
        return User::where('id', '!=', $request->user()->id)->get();
    }
   
}

<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ChatInterface;
use App\Http\Interfaces\Admin\CityInterface;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatRepository implements ChatInterface
{
    // function __construct(private NotificationService $notificationService)
    // {
    // }
    public function index()
    {

        $chats = Chat::hasParticipant(auth()->user()->id)
            ->whereHas('messages')
            ->withCount('unreadMessages')
            ->with('lastMessage.user')
            ->with('participants.user', function ($query) {
                $query->where('role_id', '2')->with('user_information', function ($query) {
                    $query->select('image', 'user_id');
                })
                    ->orwhere('role_id', '3')->with('winch_information', function ($query) {
                        $query->select('image', 'winch_id');
                    })
                    ->orwhere('role_id', '4')->with('garage_information', function ($query) {
                        $query->select('image', 'garage_id');
                    });
            })
            ->latest('updated_at')
            ->get();
        return response()->json(['data' => $chats]);
    }

    public function show($chat_id)
    {
        $unreadMessages = ChatMessage::where('read', 0)->where('chat_id', $chat_id)->get();
        foreach ($unreadMessages as $message) {
            $message->update(['read' => 1]);
        }
        $chat = Chat::hasParticipant(auth()->user()->id)
            ->whereHas('messages')
            ->with('messages.user')->with('participants.user', function ($query) {
                $query->where('role_id', '2')->with('user_information', function ($query) {
                    $query->select('image', 'user_id');
                })
                    ->orwhere('role_id', '3')->with('winch_information', function ($query) {
                        $query->select('image', 'winch_id');
                    })
                    ->orwhere('role_id', '4')->with('garage_information', function ($query) {
                        $query->select('image', 'garage_id');
                    });
            })
            ->latest('updated_at')
            ->find($chat_id);

        return $chat;
        // return $this->success($chat);
    }


    // store Chat
    public function store($request)
    {
        $data = $this->prepareStoreData($request);

        // chat only between customer and provider
        $result = $this->chatParticipantCheck($data['otherUserId']);
        if ($result) {
            return $result;
        }

        // if ($data['userId'] === $data['otherUserId']) {
        //     return response()->json(['message' => 'You can not create a chat with your own'], 404);
        // }

        $chat = $this->getPreviousChat($data['otherUserId']);
        if ($chat === null) {

            $chat = Chat::create($data['data']);
            $chat->participants()->createMany([
                [
                    'user_id' => $data['userId']
                ],
                [
                    'user_id' => $data['otherUserId']
                ]
            ]);
            $chat =   $this->getPreviousChat($data['otherUserId']);

            // $chat->refresh()->load('lastMessage.user', 'participants.user');
            // return response()->json(['data' => $chat]);
        }
        // $chat = $chat->with('lastMessage.user')->with('participants.user', function ($query) {
        //     $query->where('user_type', 'user')->with('user_information', function ($query) {
        //         $query->select('personal_photo', 'user_id');
        //     })
        //         ->orwhere('user_type', 'company')->with('company_information', function ($query) {
        //             $query->select('company_logo', 'company_id');
        //         });
        // })->first();

        return response()->json(['data' => $chat]);
    }


    private function prepareStoreData($request)
    {
        $user =  auth()->user();
        $data = $request->validated();
        $otherUserId = (int)$data['user_id'];
        unset($data['user_id']);
        $data['created_by'] = $user->id;

        return [
            'otherUserId' => $otherUserId,
            'userId' => $user->id,
            'data' => $data,
        ];
    }

    private function getPreviousChat(int $otherUserId): mixed
    {


        $userId = auth()->user()->id;
        $chatParticipant =  ChatParticipant::where('user_id', $otherUserId)
            ->with(['user' => function ($query) {
                $query->where('role_id', '2')->with('user_information', function ($query) {
                    $query->select('image', 'user_id');
                })
                    ->orwhere('role_id', '3')->with('winch_information', function ($query) {
                        $query->select('image', 'winch_id');
                    })
                    ->orwhere('role_id', '4')->with('garage_information', function ($query) {
                        $query->select('image', 'garage_id');
                    });
            }])
            ->with(['chat' => function ($q) use ($userId) {
                $q->with('participants', function ($qu) use ($userId) {
                    $qu->where('user_id', $userId);
                })->with(['lastMessage.user' => function ($query) {
                    $query->where('role_id', '2')->with('user_information', function ($query) {
                        $query->select('image', 'user_id');
                    })
                        ->orwhere('role_id', '3')->with('winch_information', function ($query) {
                            $query->select('image', 'winch_id');
                        })
                        ->orwhere('role_id', '4')->with('garage_information', function ($query) {
                            $query->select('image', 'garage_id');
                        });
                }]);
            }])->first();
        return $chatParticipant;
    }

    private function chatParticipantCheck($otherUserId)
    {
        $user = auth()->user();
        if ($user->user_information) {
            $user = User::where('role_id', '3')->orWhere('role_id', '4')->find($otherUserId);
            if (!$user)
                return response()->json(['message' => 'you can only chat with provider'], 404);
        }
    }





    // store message 
    public function storeMessage($request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        // validation check message
        $chatMessage = ChatMessage::create($data);

        $chatMessage->load('user', 'chat.participants');

        $this->chatRealTime($chatMessage->toArray());

        return response()->json(['data' => $chatMessage]);
    }


    private function chatRealTime($chatMessage)
    {
        if (auth()->user()->id == $chatMessage['chat']['participants'][0]['user_id'])
            $otherUserId = $chatMessage['chat']['participants'][1]['user_id'];
        else
            $otherUserId = $chatMessage['chat']['participants'][0]['user_id'];


        $user = auth()->user();

        $text = " Message From $user->full_name";
        $notification_type = 'chatMessage';
        $api =  url("api/chat/show/" . $chatMessage['chat']['id']);
        // $this->MessageFirbase($chatMessage['chat']['id'], $otherUserId, $user->full_name,  $text, $notification_type, $api, $user->id);
    }

    // public function MessageFirbase($type_id, $otherUserId, $type_name, $text, $notification_type, $api, $reciver_id)
    // {
    //     $firebaseTokens = FirbaseToken::where('user_type', false)->where('user_id', $otherUserId)->pluck('fcsToken')->all();
    //     $chat = [
    //         'title' => $type_name,
    //         'body' => $text
    //     ];

    //     $Firbase_API_KEY = 'AAAApDyvbxM:APA91bHGAjidipN5FLe0jp04umD41cZwSXOg8wTlTCDN55wOeQ7HtaO7NoVXsg7D9GT8A1VXdgkNOYzXI_xPpK9goXAFAxNSbpUeT9wxE0iuHiEuV2DDkmScLY2XPqmlb4A3_4CmE1Jd';

    //     $data = [
    //         "registration_ids" => $firebaseTokens,
    //         "notification" => $chat
    //     ];
    //     $dataString = json_encode($data);

    //     $headers = [
    //         'Authorization: key=' . $Firbase_API_KEY,
    //         'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //     curl_exec($ch);
    //     // event(new NotificationEvent($user->id));
    //     // event(new NotificationEvent($employee->company->id));
    //     return response()->json(['message' => 'Success Real Time Chat']);
    // }
}
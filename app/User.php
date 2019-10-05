<?php

namespace App;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.' . $this->id;
    }

    /** START RELATIONSHIP **/

    public function chats()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /** END RELATIONSHIP **/

    /**
     * @param int $user_id
     * @param null $name
     * @return \Illuminate\Database\Eloquent\Model|string
     */

    public function conversationCreate(int $user_id, $name = null)
    {
        $res = DB::table('conversation_user')
            ->select()
            ->join('conversation_user as c', 'c.conversation_id', '=', 'conversation_user.conversation_id')
            ->where('c.user_id', '=', auth()->id())
            ->where('conversation_user.user_id', '=', $user_id)
            ->first();

        if ($res != null) {
            return Conversation::findOrFail($res->conversation_id);
        }

        $name ?: $name = Auth::user()->name . ', ' . (User::find($user_id))->name;
        $conversation = $this->chats()->create(['name' => $name]);
        $conversation->users()->attach([auth()->id(), $user_id]);
        return $conversation;
    }

    public function messageCreate($data)
    {
        $message = $this->messages()->create($data);
        return Message::with('user')->where('id', $message->id)->first();
    }

    public static function getOthers()
    {
        return static::where('id', '!=', auth()->id())->get();
    }

    public function hasConversation($id)
    {
        $data = $this->conversations()->where('conversation_id', $id)->first();
        return $data !== null ? true : false;
    }

}

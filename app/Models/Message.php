<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'text'];

    /** START RELATIONSHIP **/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /** END RELATIONSHIP **/

    /**
     * @param $conversation_id
     * @return
     */

    public static function byConversation($conversation_id)
    {
        return static::where('conversation_id', $conversation_id)->with('user')->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Room extends Model
{
    use HasFactory;

    const From_id = 'from_id';
    const To_id = 'to_id';
    const Message_id = 'message_id';
    const Type = 'type';
    const From_delete_status = 'from_delete_status';
    const To_delete_status = 'to_delete_status';
    const To_seeing_status = 'To_seeing_status';

    protected $fillable = [
        self::From_id,
        self::To_id,
        self::Message_id,
        self::Type,
        self::From_delete_status,
        self::To_delete_status,
        self::To_seeing_status,
    ];

    protected $ownFields = [
        self::From_id,
        self::To_id,
        self::Message_id,
        self::Type,
        self::From_delete_status,
        self::To_delete_status,
        self::To_seeing_status,
    ];

    public function fromUser(){
        return $this->belongsTo(User::class,'from_id');
    }

    public function toUser(){
        return $this->belongsTo(User::class,'to_id');
    }

    public function messages(){
        return $this->hasMany(Message::class,'id','message_id');
    }

}

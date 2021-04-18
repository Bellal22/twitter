<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    // protected $fillable = ['user_id','text'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function count_all()
    {
        return self::count();
    }
    public function format()
    {
        return [
            'user_id' => $this->id,
            'created_by' => $this->user->name,
            'tweet' => $this->text,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }

}

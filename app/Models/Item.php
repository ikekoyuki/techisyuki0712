<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'area',
        'type',
        'detail',
        'purchasedate',
        'dumpdate'
    ];

    public const Area = [
        "リビング",
        "寝室",
        "キッチン",
        "玄関",
        "トイレ・バス",
        "その他"
    ];

    public const Type = [
        "必要",
        "大切",
        "保留",
        "捨てる"
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Upload;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'id_image',
        'address',
        'telp',
        'link',
        'orderto',
        'email',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y');
    }

    /**
     * Get the user that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getImage(): BelongsTo
    {
        return $this->belongsTo(Upload::class, 'id_image', 'id');
    }
}

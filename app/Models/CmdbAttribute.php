<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmdbAttribute extends Model
{
    protected $fillable = ['cmdb_item_id', 'key', 'value'];

    public function item()
    {
        return $this->belongsTo(CmdbItem::class);
    }
}

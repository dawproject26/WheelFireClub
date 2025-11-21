<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Phrase extends Model
{
protected $fillable = ['panel_id', 'phrase'];


public function panel()
{
return $this->belongsTo(Panel::class);
}
}
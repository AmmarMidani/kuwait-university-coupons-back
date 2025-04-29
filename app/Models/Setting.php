<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = ['id', 'option_name', 'option_key', 'option_value', 'created_at', 'updated_at'];

    public function get_key($key)
    {
        return $this->where('option_key', $key)->first();
    }

    public function set_key($key, $value, $name)
    {
        $data = $this->where('option_key', $key)->first();
        if (!$data) {
            $data = $this;
        }
        $data->option_name = $name;
        $data->option_key = $key;
        $data->option_value = $value;
        $data->save();
    }
}

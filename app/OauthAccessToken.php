<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    public  function AauthAccessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }
}

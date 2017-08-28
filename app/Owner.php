<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
   public static function getOwner(){
        return 'Owner name is mysql';
   }

}

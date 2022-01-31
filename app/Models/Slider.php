<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use CommonFunctions;
    /****************************
     * Property area
     *****************************/
    protected $fillable = ['image','title'];

    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(  User::class, 'user_id');
    }

    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */

    public function GetData($data)
    {
        if (isset($data['image']))
        {
            $data['image']= $this->UploadImage($data['image'],'sliders');

        }
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/

     public function getImageAttribute($value) {
         return url('/').'/'.$value;
     }
}

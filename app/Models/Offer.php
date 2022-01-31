<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'title_bn',
        'title_en',
        'description_bn',
        'description_en',
    ];

    /****************************
     * Model Relation area
     *****************************/


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
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/
}

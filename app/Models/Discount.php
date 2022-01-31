<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use CommonFunctions;
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'title_en',
        'title_bn',
        'description_en',
        'description_bn',
        'discount_percent',
        'amount',
        'is_percent'
    ];

    /****************************
     * Model Relation area
     *****************************/
    public function orders()
    {
        return $this->hasMany(Order::class);
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
        $data['is_percent']=$this->GetCheckBoxValue($data,'is_percent');
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/
}

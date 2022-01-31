<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'title',
        'description',
        'quantity',
        'phone',
        'address',
        'status'
    ];

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
        return $data;
    }

    /****************************
     * Public Methods area
     *****************************/

    public function GetProductRequests()
    {
        return ProductRequest::orderBy('id','desc')->get();
    }
}

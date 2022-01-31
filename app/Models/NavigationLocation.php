<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationLocation extends Model
{
    /****************************
     * Property area
     *****************************/
    protected $fillable = ['name'];

    /****************************
     * Model Relation area
     *****************************/

    public function pages()
    {
        return $this->hasMany(  Page::class, 'navigation_location_id');
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
}

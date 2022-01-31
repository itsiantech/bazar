<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use CommonFunctions;
    /****************************
     * Property area
     *****************************/
    protected $fillable = ['title','body','body_bn','banner_image','navigation_location_id'];

    /****************************
     * Model Relation area
     *****************************/

    public function navigationLocation()
    {
        return $this->belongsTo(  NavigationLocation::class);
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
        if (isset($data['banner_image'])) {
            $data['banner_image'] = $this->UploadImage($data['banner_image'], 'pages');

        }
        return $data;
    }

    public function UpdateData($data, $oldData)
    {
        if (isset($data['banner_image'])) {

            $data['banner_image'] = $this->UpdateImage($data['banner_image'], 'pages', $oldData->banner_image);

        }
        return $data;
    }

    public function GetSinglePage($slug)
    {
        $title = $this->dSlug($slug);
        $page = Page::where('title',$title)->first();
        return $page;
    }
    public function dSlug($slug)
    {
        return str_replace("-", " ", $slug);
    }
    /****************************
     * Public Methods area
     *****************************/
}

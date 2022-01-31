<?php

namespace App\Models;

use App\Models\User;
use App\Traits\CommonFunctions;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class Profile extends Model
{
    use CommonFunctions;

    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'blood_group',
        'profile_image',
        'date_of_birth'
    ];

    /****************************
     * Model Relation area
     *****************************/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
//        dd($data['profile_image']->getPathname());
        $data['user_id'] = Auth::user()->id;
        if (isset($data['profile_image']))
        {
            $data['profile_image'] = $this->UploadImage($data['profile_image'], 'profiles');

        }
        return $data;
    }

    public function SaveOrUpdateProfile($data)
    {
        $result = false;
        $profile = $this->GetProfile();
        if ($profile != null) {
            $this->RemoveImage($profile->profile_image);
            if ($profile->update($data)) {
                $result = true;
            }
        } else {
            $profile = Profile::create($data);
            if ($profile) {
                $result = true;
            }
        }

        $profile->user()->update(['name' => $profile->first_name.' '.$profile->last_name]);


        return $result;
    }

    public function GetProfile()
    {
        return Profile::with('user', 'user.wallet')->where('user_id',Auth::user()->id)->first();
    }
    /****************************
     * Public Methods area
     *****************************/

}

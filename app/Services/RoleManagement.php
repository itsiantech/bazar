<?php

namespace App\Services;

class RoleManagement{
    public function SyncRole($user, $request, $route)
    {
        if($user->email == 'gdnayeem1996@gmail.com') return redirect()->route($route);

        $form_data = $request->validated();


        $user->syncRoles($form_data['role_id']);

        return redirect()->route($route);
    }
}

<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionGeneratorService
{
    public $user;

    public function __construct()
    {
        $user = User::where('email', 'gdnayeem1996@gmail.com')->first();

        if (empty($user))
            $user = User::firstOrCreate(['name' => 'Jannatul Nayeem', 'phone' => '011','email' => 'gdnayeem1996@gmail.com', 'password' => Hash::make(12345678), 'type' => 'admin', 'is_verified' => true]);

        $this->user = $user;
    }


    public function generate()
    {
        try{
            $this->generateAdminPermissions($this->user, 'web');

            return true;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    private function generateAdminPermissions($user, $guardName)
    {
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guardName]);

        $user->assignRole($role);

        $permissions = [
            Permission::firstOrCreate(['name' => 'view-slider', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-slider', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-slider', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-slider', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-slider', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-brand', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-brand', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-brand', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-brand', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-brand', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-category', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-category', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-category', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-category', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-category', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-coupon', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-coupon', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-coupon', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-coupon', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-coupon', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-discount', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-discount', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-discount', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-discount', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-discount', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-delivery-charge', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-delivery-charge', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-delivery-charge', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-delivery-charge', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-delivery-charge', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-products', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-products', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-products', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-products', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-products', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-bundle', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-bundle', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-bundle', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-bundle', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-bundle', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-product-request', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-product-request', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-product-request', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-product-request', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-product-request', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-user', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-user', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-user', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-user', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-user', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-employee', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-employee', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-employee', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-employee', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-employee', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-refund', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-refund', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-refund', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-refund', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-refund', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-setting', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-setting', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-setting', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-setting', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-setting', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-order', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'discount-order', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'revoke-order', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-order', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-order', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-page', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-page', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-page', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-page', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-page', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-role', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'create-role', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'edit-role', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'delete-role', 'guard_name' => $guardName]),
            Permission::firstOrCreate(['name' => 'force-delete-role', 'guard_name' => $guardName]),

            Permission::firstOrCreate(['name' => 'view-permissions', 'guard_name' => $guardName]),
        ];

        $role->givePermissionTo($permissions);
    }

//    private function generateOtherDemoGuardPermissions($guardName)
//    {
//
//        $role = Role::firstOrCreate(['name' => $guardName, 'guard_name' => $guardName]);
//
//        $permissions = [
//            Permission::firstOrCreate(['name' => 'view-user-profile', 'guard_name' => $guardName]),
//        ];
//        $role->givePermissionTo($permissions);
//
//    }


}

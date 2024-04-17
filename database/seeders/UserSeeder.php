<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSAdmin = User::class::create([
            'name' => 'SuperAdmin',
            'email' => 'nasuarezro@unal.edu.co',
            'email_verified_at' => now(),
            'password' => bcrypt('GymUnalCAPF'),
        ]);

        $userAdmin = User::class::create([
            'name' => 'Admin',
            'email' => 'jarroyavea@unal.edu.co',
            'email_verified_at' => now(),
            'password' => bcrypt('AdminCapfUNAL!'),
        ]);

        $userAsist = User::class::create([
            'name' => 'Asistente',
            'email' => 'capf@unal.edu.co',
            'email_verified_at' => now(),
            'password' => bcrypt('AsistenteCAPF123!'),
        ]);

        // Accrued, Client, Degree, Faculty, Fee, Permission, Role, Subscription, User

        Permission::create(['name' => 'Pay.ViewAny']);
        Permission::create(['name' => 'Pay.View']);
        Permission::create(['name' => 'Pay.Create']);
        Permission::create(['name' => 'Pay.Update']);
        Permission::create(['name' => 'Pay.Delete']);
        Permission::create(['name' => 'Pay.Restore']);
        Permission::create(['name' => 'Pay.ForceDelete']);

        Permission::create(['name' => 'Client.ViewAny']);
        Permission::create(['name' => 'Client.View']);
        Permission::create(['name' => 'Client.Create']);
        Permission::create(['name' => 'Client.Update']);
        Permission::create(['name' => 'Client.Delete']);
        Permission::create(['name' => 'Client.Restore']);
        Permission::create(['name' => 'Client.ForceDelete']);

        Permission::create(['name' => 'Degree.ViewAny']);
        Permission::create(['name' => 'Degree.View']);
        Permission::create(['name' => 'Degree.Create']);
        Permission::create(['name' => 'Degree.Update']);
        Permission::create(['name' => 'Degree.Delete']);
        Permission::create(['name' => 'Degree.Restore']);
        Permission::create(['name' => 'Degree.ForceDelete']);

        Permission::create(['name' => 'Faculty.ViewAny']);
        Permission::create(['name' => 'Faculty.View']);
        Permission::create(['name' => 'Faculty.Create']);
        Permission::create(['name' => 'Faculty.Update']);
        Permission::create(['name' => 'Faculty.Delete']);
        Permission::create(['name' => 'Faculty.Restore']);
        Permission::create(['name' => 'Faculty.ForceDelete']);

        Permission::create(['name' => 'Fee.ViewAny']);
        Permission::create(['name' => 'Fee.View']);
        Permission::create(['name' => 'Fee.Create']);
        Permission::create(['name' => 'Fee.Update']);
        Permission::create(['name' => 'Fee.Delete']);
        Permission::create(['name' => 'Fee.Restore']);
        Permission::create(['name' => 'Fee.ForceDelete']);

        Permission::create(['name' => 'Permission.ViewAny']);
        Permission::create(['name' => 'Permission.View']);
        Permission::create(['name' => 'Permission.Create']);
        Permission::create(['name' => 'Permission.Update']);
        Permission::create(['name' => 'Permission.Delete']);
        Permission::create(['name' => 'Permission.Restore']);
        Permission::create(['name' => 'Permission.ForceDelete']);

        Permission::create(['name' => 'Role.ViewAny']);
        Permission::create(['name' => 'Role.View']);
        Permission::create(['name' => 'Role.Create']);
        Permission::create(['name' => 'Role.Update']);
        Permission::create(['name' => 'Role.Delete']);
        Permission::create(['name' => 'Role.Restore']);
        Permission::create(['name' => 'Role.ForceDelete']);

        Permission::create(['name' => 'Subscription.ViewAny']);
        Permission::create(['name' => 'Subscription.View']);
        Permission::create(['name' => 'Subscription.Create']);
        Permission::create(['name' => 'Subscription.Update']);
        Permission::create(['name' => 'Subscription.Delete']);
        Permission::create(['name' => 'Subscription.Restore']);
        Permission::create(['name' => 'Subscription.ForceDelete']);

        Permission::create(['name' => 'Admins.ViewAny']);
        Permission::create(['name' => 'Admins.View']);
        Permission::create(['name' => 'Admins.Create']);
        Permission::create(['name' => 'Admins.Update']);
        Permission::create(['name' => 'Admins.Delete']);
        Permission::create(['name' => 'Admins.Restore']);
        Permission::create(['name' => 'Admins.ForceDelete']);

        Role::create(['name' => 'SuperAdmin'])
            ->givePermissionTo([
                'Pay.ViewAny',
                'Pay.View',
                'Pay.Create',
                'Pay.Update',
                'Pay.Delete',
                'Pay.Restore',
                'Pay.ForceDelete',
                'Client.ViewAny',
                'Client.View',
                'Client.Create',
                'Client.Update',
                'Client.Delete',
                'Client.Restore',
                'Client.ForceDelete',
                'Degree.ViewAny',
                'Degree.View',
                'Degree.Create',
                'Degree.Update',
                'Degree.Delete',
                'Degree.Restore',
                'Degree.ForceDelete',
                'Faculty.ViewAny',
                'Faculty.View',
                'Faculty.Create',
                'Faculty.Update',
                'Faculty.Delete',
                'Faculty.Restore',
                'Faculty.ForceDelete',
                'Fee.ViewAny',
                'Fee.View',
                'Fee.Create',
                'Fee.Update',
                'Fee.Delete',
                'Fee.Restore',
                'Fee.ForceDelete',
                'Permission.ViewAny',
                'Permission.View',
                'Permission.Create',
                'Permission.Update',
                'Permission.Delete',
                'Permission.Restore',
                'Permission.ForceDelete',
                'Role.ViewAny',
                'Role.View',
                'Role.Create',
                'Role.Update',
                'Role.Delete',
                'Role.Restore',
                'Role.ForceDelete',
                'Subscription.ViewAny',
                'Subscription.View',
                'Subscription.Create',
                'Subscription.Update',
                'Subscription.Delete',
                'Subscription.Restore',
                'Subscription.ForceDelete',
                'Admins.ViewAny',
                'Admins.View',
                'Admins.Create',
                'Admins.Update',
                'Admins.Delete',
                'Admins.Restore',
                'Admins.ForceDelete',
            ]);
        Role::create(['name' => 'Administrador'])
            ->givePermissionTo([
                'Pay.ViewAny',
                'Pay.View',
                'Pay.Create',
                'Pay.Update',
                'Pay.Delete',
                'Pay.Restore',
                'Pay.ForceDelete',
                'Client.ViewAny',
                'Client.View',
                'Client.Create',
                'Client.Update',
                'Client.Delete',
                'Client.Restore',
                'Client.ForceDelete',
                'Degree.ViewAny',
                'Degree.View',
                'Degree.Create',
                'Degree.Update',
                'Degree.Delete',
                'Degree.Restore',
                'Degree.ForceDelete',
                'Faculty.ViewAny',
                'Faculty.View',
                'Faculty.Create',
                'Faculty.Update',
                'Faculty.Delete',
                'Faculty.Restore',
                'Faculty.ForceDelete',
                'Fee.ViewAny',
                'Fee.View',
                'Fee.Create',
                'Fee.Update',
                'Fee.Delete',
                'Fee.Restore',
                'Fee.ForceDelete',
                'Subscription.ViewAny',
                'Subscription.View',
                'Subscription.Create',
                'Subscription.Update',
                'Subscription.Delete',
                'Subscription.Restore',
                'Subscription.ForceDelete',
                'Admins.ViewAny',
                'Admins.View',
                'Admins.Create',
                'Admins.Update',
                'Admins.Delete',
                'Admins.Restore',
                'Admins.ForceDelete',
            ]);
        Role::create(['name' => 'Asistente'])
            ->givePermissionTo([
                'Pay.ViewAny',
                'Pay.View',
                'Client.ViewAny',
                'Client.View',
                'Client.Create',
                'Client.Update',
            ]);

        $userSAdmin->assignRole('SuperAdmin');
        $userSAdmin->assignRole('Administrador');

        $userAdmin->assignRole('Administrador');
        $userAsist->assignRole('Asistente');


    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdminPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminEmails = array_map('strtolower', config('event.super_admin_emails', []));
        $allAdminEmails = array_map('strtolower', config('event.admin_emails', []));

        $resources = ['dashboard', 'registrations', 'checkins', 'event-feedback', 'referrals', 'leaderboard', 'influencers', 'stalls'];

        foreach ($allAdminEmails as $email) {
            $email = strtolower($email);
            $isSuper = in_array($email, $superAdminEmails, true);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $this->guessName($email),
                    'password' => Hash::make('ArihantPlus@123'),
                    'role' => 'admin',
                    'is_super_admin' => $isSuper,
                    'can_view_pii' => $isSuper,
                ]
            );

            if ($isSuper) {
                $this->command->info(" [SUPER] {$user->name} <{$user->email}>");
                continue;
            }

            foreach ($resources as $resource) {
                AdminPermission::firstOrCreate(
                    ['user_id' => $user->id, 'resource' => $resource],
                    ['view' => true, 'create' => false, 'edit' => false, 'delete' => false, 'export' => false]
                );
            }

            $this->command->info(" [ADMIN] {$user->name} <{$user->email}>");
        }

        $this->command->info('');
        $this->command->info('Admin permissions seeded successfully.');
    }

    private function guessName(string $email): string
    {
        [$local] = explode('@', $email, 2);
        $parts = explode('.', $local);
        $name = '';
        foreach ($parts as $part) {
            $name .= ucfirst($part) . ' ';
        }
        return trim($name);
    }
}

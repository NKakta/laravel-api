<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /** @var int */
    public const DEFAULT_USER_ID = 1;
    public const USER_ID_2 = 2;

    /** @var string */
    public const DEFAULT_USER_EMAIL = 'test@gmail.com';
    public const USER_EMAIL_2 = 'user@gmail.com';

    /** @var string */
    public const DEFAULT_USER_PASSWORD = 'test123';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createUser(
            self::DEFAULT_USER_ID,
            'test',
            self::DEFAULT_USER_EMAIL,
            self::DEFAULT_USER_PASSWORD
        );

        $this->createUser(
            self::USER_ID_2,
            'user',
            self::USER_EMAIL_2,
            self::DEFAULT_USER_PASSWORD
        );
    }

    private function createUser($id, $name, $email, $password, $createdAt = null)
    {
        return User::create([
            'id'            => $id,
            'uuid'          => $id,
            'name'          => $name,
            'email'         => $email,
            'password'      => Hash::make($password),
            'created_at'    => $createdAt ?? now(),
            'updated_at'    => $createdAt ?? now()
        ]);
    }
}

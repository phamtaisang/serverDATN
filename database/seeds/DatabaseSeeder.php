<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Nguyen Van B'],
            ['email' => 'nguyenvanb@gmail.com'],
            ['description' => 'Thich di choi xa'],
            ['cover' => NULL],
            ['avatar' => 'https://www.google.com/search?q=avatar+facebook&sxsrf=ALeKk0115GvxwNtoBfON-heCtnmJwLaTPw:1622857453204&tbm=isch&source=iu&ictx=1&fir=sKXUlQaZcHUT3M%252CDXMUdhTdWnZWrM%252C_&vet=1&usg=AI4_-kSLZdyk7HTkLp-AlwqjMOs9GD1Bdg&sa=X&ved=2ahUKEwjYpJOQr__wAhVDyosBHbFmDB4Q9QF6BAgMEAE#imgrc=sKXUlQaZcHUT3M'],
            ['address' => 'Thanh Oai'],
            ['gender' => NULL],
            ['phone' => '0355161412'],
            ['email_verified_at' => NULL],
            ['password' => '$2y$10$Q3JKLnHodfbdWFT7D7OJ1OtNVrmj3NLUX2Dranbi2Kx7onddIEs.S'],
            ['remember_token' => NULL]    
        ]);
    }
}

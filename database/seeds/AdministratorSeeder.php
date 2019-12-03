<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $administrator = new \App\User;
        $administrator->username = "Yogi Nugraha";
        $administrator->name = "Made Yogi Nugraha";
        $administrator->email = "yoginugraha19@gmail.com";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("supersekali");
        $administrator->avatar = "saat-ini-tidak-ada-file.png";
        $administrator->address = "Sarmili, Bintaro, Tangerang Selatan";
        $administrator->phone = "089468416847";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }
}

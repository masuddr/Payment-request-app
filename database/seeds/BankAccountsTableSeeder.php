<?php

use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_accounts')->insert([
            'name' => 'Masuds bankrekening',
            'banking_number' => 'NL59RABO0157649989',
            'user_id' => 1,
        ]);

        DB::table('bank_accounts')->insert([
            'name' => 'Darjushs bankrekening',
            'banking_number' => 'NL91INGB0004970020',
            'user_id' => 2,
        ]);
    }
}

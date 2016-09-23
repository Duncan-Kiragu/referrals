<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Referral;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $initUser = new User();
      $initUser->name = 'Gage LaFleur';
      $initUser->email = 'gpl9310@gmail.com';
      $initUser->password = bcrypt('R1ddenc3');
      $initUser->save();

      $initReferrer = new User();
      $initReferrer->name = 'Gage LaFleur';
      $initReferrer->email = 'gagelafleur@gmail.com';
      $initReferrer->password = bcrypt('R1ddenc3');
      $initReferrer->save();

      $initWholesaler = new User();
      $initWholesaler->name = 'Gage LaFleur';
      $initWholesaler->email = 'gage.lafleur@gmail.com';
      $initWholesaler->password = bcrypt('R1ddenc3');
      $initWholesaler->save();

      $admin = new Role();
      $admin->name         = 'admin';
      $admin->display_name = 'User Administrator'; // optional
      $admin->description  = 'User is allowed to manage and edit other users'; // optional
      $admin->save();

      $referrer = new Role();
      $referrer->name         = 'referrer';
      $referrer->display_name = 'Referrer'; // optional
      $referrer->description  = 'User is to view own referrals'; // optional
      $referrer->save();

      $wholesaler = new Role();
      $wholesaler->name         = 'wholesaler';
      $wholesaler->display_name = 'Wholesaler'; // optional
      $wholesaler->description  = 'User is to view referrals of associate referrers and own referrals'; // optional
      $wholesaler->save();

      $user = User::where('email', '=', 'gpl9310@gmail.com')->first();
      $user->attachRole($admin);

      $userReferrer = User::where('email', '=', 'gagelafleur@gmail.com')->first();
      $userReferrer->attachRole($referrer);

      $referral = new Referral();
      $referral->user_id = $userReferrer->id;
      $referral->referral_email = "test@test.com";
      $referral->referral_amount = 100.00;
      $referral->save();

      $referral = new Referral();
      $referral->user_id = $userReferrer->id;
      $referral->referral_email = "test2@test.com";
      $referral->referral_amount = 125.00;
      $referral->save();

      $referral = new Referral();
      $referral->user_id = $userReferrer->id;
      $referral->referral_email = "test3@test.com";
      $referral->referral_amount = 125.00;
      $referral->save();

      $userWholesaler = User::where('email', '=', 'gage.lafleur@gmail.com')->first();
      $userWholesaler->attachRole($wholesaler);


    }
}

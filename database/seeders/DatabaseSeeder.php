<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use App\Models\MaintenanceRequest;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>Hash::make('password'),'role'=>'admin']);
        User::create(['name'=>'Ahmed','email'=>'ahmed@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        User::create(['name'=>'Sara','email'=>'sara@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        User::create(['name'=>'Omar','email'=>'omar@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        User::create(['name'=>'Lina','email'=>'lina@example.com','password'=>Hash::make('password'),'role'=>'technician']);
    }
}
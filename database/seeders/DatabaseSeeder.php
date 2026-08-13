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
        $ahmed = User::create(['name'=>'Ahmed','email'=>'ahmed@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        $sara = User::create(['name'=>'Sara','email'=>'sara@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        User::create(['name'=>'Omar','email'=>'omar@example.com','password'=>Hash::make('password'),'role'=>'technician']);
        User::create(['name'=>'Lina','email'=>'lina@example.com','password'=>Hash::make('password'),'role'=>'technician']);

        $c1 = Customer::create(['name'=>'Customer One','email'=>'c1@example.com','phone'=>'0599000001','address'=>'Nablus']);
        $c2 = Customer::create(['name'=>'Customer Two','email'=>'c2@example.com','phone'=>'0599000002','address'=>'Ramallah']);
        $c3 = Customer::create(['name'=>'Customer Three','email'=>'c3@example.com','phone'=>'0599000003','address'=>'Jenin']);

        MaintenanceRequest::create(['customer_id'=>$c1->id,'technician_id'=>$ahmed->id,'title'=>'Fix AC','description'=>'AC not working','priority'=>'high','status'=>'pending','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c2->id,'technician_id'=>$sara->id,'title'=>'Fix PC','description'=>'PC is slow','priority'=>'medium','status'=>'in_progress','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c3->id,'technician_id'=>$ahmed->id,'title'=>'Fix Printer','description'=>'Printer offline','priority'=>'low','status'=>'completed','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c1->id,'technician_id'=>null,'title'=>'Network issue','description'=>'No internet','priority'=>'high','status'=>'pending','requested_at'=>now()]);
    }
}
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
        $c4 = Customer::create(['name'=>'Customer Four','email'=>'c4@example.com','phone'=>'0599000004','address'=>'Hebron']);
        $c5 = Customer::create(['name'=>'Customer Five','email'=>'c5@example.com','phone'=>'0599000005','address'=>'Tulkarm']);
        $c6 = Customer::create(['name'=>'Customer Six','email'=>'c6@example.com','phone'=>'0599000006','address'=>'Bethlehem']);
        $c7 = Customer::create(['name'=>'Customer Seven','email'=>'c7@example.com','phone'=>'0599000007','address'=>'Jericho']);
        $c8 = Customer::create(['name'=>'Customer Eight','email'=>'c8@example.com','phone'=>'0599000008','address'=>'Qalqilya']);

        MaintenanceRequest::create(['customer_id'=>$c1->id,'technician_id'=>$ahmed->id,'title'=>'Fix AC','description'=>'AC not working','priority'=>'high','status'=>'pending','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c2->id,'technician_id'=>$sara->id,'title'=>'Fix PC','description'=>'PC is slow','priority'=>'medium','status'=>'in_progress','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c3->id,'technician_id'=>$ahmed->id,'title'=>'Fix Printer','description'=>'Printer offline','priority'=>'low','status'=>'completed','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c1->id,'technician_id'=>null,'title'=>'Network issue','description'=>'No internet','priority'=>'high','status'=>'pending','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c4->id,'technician_id'=>$sara->id,'title'=>'Replace router','description'=>'Router keeps restarting','priority'=>'high','status'=>'in_progress','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c5->id,'technician_id'=>$ahmed->id,'title'=>'Install software','description'=>'Needs accounting software installed','priority'=>'low','status'=>'completed','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c6->id,'technician_id'=>null,'title'=>'Broken screen','description'=>'Laptop screen is cracked','priority'=>'medium','status'=>'pending','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c7->id,'technician_id'=>$sara->id,'title'=>'Server backup','description'=>'Backup job fails every night','priority'=>'high','status'=>'in_progress','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c8->id,'technician_id'=>$ahmed->id,'title'=>'Clean printer heads','description'=>'Printouts have missing lines','priority'=>'low','status'=>'completed','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c2->id,'technician_id'=>null,'title'=>'Email not syncing','description'=>'Outlook stopped syncing since Monday','priority'=>'medium','status'=>'pending','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c3->id,'technician_id'=>$sara->id,'title'=>'Upgrade RAM','description'=>'Machine needs more memory for design work','priority'=>'medium','status'=>'cancelled','requested_at'=>now()]);
        MaintenanceRequest::create(['customer_id'=>$c4->id,'technician_id'=>$ahmed->id,'title'=>'CCTV offline','description'=>'Two cameras are not recording','priority'=>'high','status'=>'completed','requested_at'=>now()]);
    }
}
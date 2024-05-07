<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Monstar People', 'url' => 'monstar-people.com','description'=>'A human resource management system that helps you manage your employees and their data'],
            ['id' => 2, 'name' => 'Monstar Bill', 'url' => 'monstar-bill.com','description'=>'A cloud-based billing software that helps you manage your business billing.'],
            ['id' => 3, 'name' => 'Monstar Expense', 'url' => 'monstar-hrm.com','parent_id'=>1,'description'=>'A cloud-based expense management software that helps you manage your business expenses.'],
            ['id' => 4, 'name' => 'Monstar Book', 'url' => 'monstar-book.com','description'=>'A cloud-based accounting software that helps you manage your business finance.'],
            ['id' => 5, 'name' => 'Monstar Attendance', 'url' => 'monstar-attendance.com','parent_id'=>1,'description'=>'Brief Description of Attendance in a few words'],
            ['id' => 6, 'name' => 'Monstar Payroll', 'url' => 'monstar-payroll.com','parent_id'=>1,'description'=>'Brief Description of Payroll in a few words'],
            ['id' => 7, 'name' => 'Monstar HRM', 'url' => 'monstar-hrm.com','parent_id'=>1,'description'=>'Brief Description of HRM in a few words'],
            ['id' => 8, 'name' => 'Monstar Suite', 'url' => 'monstar-suite.com','description'=>'Brief Description of Suite in a few words'],

        ];
        foreach ($data as $product) {
            Product::create($product);
        }
    }
}

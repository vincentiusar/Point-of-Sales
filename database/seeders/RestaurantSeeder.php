<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurants')->insert([
            [
                'id' => 1,
                'name' => 'ada namanya',
                'description' => 'restoran yang bisa buat orang sentolop',
                'address' => 'jalan sentolop raya',
                'images' => 'https://storage.googleapis.com/point-of-sales-26efb.appspot.com/images/leblanc.jpg?GoogleAccessId=firebase-adminsdk-bf969%40point-of-sales-26efb.iam.gserviceaccount.com&Expires=2934835200&Signature=yM6WPXVDLUzylV2uPoUahb5d7sc0nxVDCLC%2BWk3uM32R1PAckDr9p2spoXsTAFVqmzL0I34kfkgPWLxH20TYuqz2569fg3TYVTpTnxY9VnDArmP9Mj0YtyRdQ8Jj1SRKBxau8vDNKTsc5goksX6iVCp0J%2B7s%2B2Un6V4gStTe%2FpVUMpmqKTMz7C85diDK3pJMsmX7mvsH3qLacQbAs5XJvdfdcA4hdx7R4xsM29vAQXpRYfbv6iQw4H8uTdpG30NbHRpZQswUfziCRWMnhusIZv07CZf8E032muSh%2FYtJ4gyunsr07BvsBCWHvOSxs3e8IJI0fs3VyjWOy%2BNOvGJ8iA%3D%3D',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'ASTAGOT',
                'description' => 'Resto ini ganti nama',
                'address' => 'adadda',
                'images' => 'https://storage.googleapis.com/point-of-sales-26efb.appspot.com/images/leblanc.jpg?GoogleAccessId=firebase-adminsdk-bf969%40point-of-sales-26efb.iam.gserviceaccount.com&Expires=2934835200&Signature=yM6WPXVDLUzylV2uPoUahb5d7sc0nxVDCLC%2BWk3uM32R1PAckDr9p2spoXsTAFVqmzL0I34kfkgPWLxH20TYuqz2569fg3TYVTpTnxY9VnDArmP9Mj0YtyRdQ8Jj1SRKBxau8vDNKTsc5goksX6iVCp0J%2B7s%2B2Un6V4gStTe%2FpVUMpmqKTMz7C85diDK3pJMsmX7mvsH3qLacQbAs5XJvdfdcA4hdx7R4xsM29vAQXpRYfbv6iQw4H8uTdpG30NbHRpZQswUfziCRWMnhusIZv07CZf8E032muSh%2FYtJ4gyunsr07BvsBCWHvOSxs3e8IJI0fs3VyjWOy%2BNOvGJ8iA%3D%3D',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}

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
                'images' => 'https://storage.googleapis.com/point-of-sales-26efb.appspot.com/images/leblanc.jpg?GoogleAccessId=firebase-adminsdk-bf969%40point-of-sales-26efb.iam.gserviceaccount.com&Expires=1679184000&Signature=A7%2FPa6w2zZUA8Rk9RWl0qRU3mT7Ct%2B6AVe68ClaLw4TyvV9UQ8ztjw%2Bb5COURkDl3KuFaP7HrEb4VIPoB0Y%2BK2gpes2G2Zwm5SMWOkgRfKc2e50a%2FMeEdqLguWOenyFLmBa%2BjOKFsedbYr%2FEYJR0XO4e7TbglmleWD%2BRgDYrQ9LD8cEEITgm3FsK%2BAaj%2BcgRZDozQAePomXNi0GxUEt6%2BnSA7Pn%2Bs%2FouOJGE5WZFUWQrQnbMGnereTyiOACBFrqRbDPHQuOFeORZ577am5tfz0KEJjSGYC%2F4n2%2BKxtiOAiVaHDIKs5t1Bp8A%2FO2ZI0y0R2kU2SqrfD%2BUVDXcteNDww%3D%3D',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'ASTAGOT',
                'description' => 'Resto ini ganti nama',
                'address' => 'adadda',
                'images' => 'https://storage.googleapis.com/point-of-sales-26efb.appspot.com/images/leblanc.jpg?GoogleAccessId=firebase-adminsdk-bf969%40point-of-sales-26efb.iam.gserviceaccount.com&Expires=1679184000&Signature=A7%2FPa6w2zZUA8Rk9RWl0qRU3mT7Ct%2B6AVe68ClaLw4TyvV9UQ8ztjw%2Bb5COURkDl3KuFaP7HrEb4VIPoB0Y%2BK2gpes2G2Zwm5SMWOkgRfKc2e50a%2FMeEdqLguWOenyFLmBa%2BjOKFsedbYr%2FEYJR0XO4e7TbglmleWD%2BRgDYrQ9LD8cEEITgm3FsK%2BAaj%2BcgRZDozQAePomXNi0GxUEt6%2BnSA7Pn%2Bs%2FouOJGE5WZFUWQrQnbMGnereTyiOACBFrqRbDPHQuOFeORZ577am5tfz0KEJjSGYC%2F4n2%2BKxtiOAiVaHDIKs5t1Bp8A%2FO2ZI0y0R2kU2SqrfD%2BUVDXcteNDww%3D%3D',
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
        ]);
    }
}

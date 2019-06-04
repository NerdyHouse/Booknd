<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert(
                [
                    'user_id'   => 1,
                    'book_id'   => 3,
                    'rating'    => 5,
                    'review'    => 'This book was very good. I liked it alot and would totally read it again. I definitely recommend this book to anyone who likes books similar to this. You should totally go and get this book and read it over and over again. That is what I am doing.'
                    ]
                );
    }
}

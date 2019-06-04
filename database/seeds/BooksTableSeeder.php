<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert(
        [
            'title' => 'Harry Potter And The Chamber Of Secrets',
            'author_id' => 1,
            'summary' => 'Harry Potter goes into a chamber and discovers some secrets. He does more magical stuff.',
            'isbn10'  => '0439064872',
            'isbn13'  => '978-0439064873',
            'image'   => NULL,
        ]);
    }
}

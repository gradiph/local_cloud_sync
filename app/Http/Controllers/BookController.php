<?php

namespace App\Http\Controllers;

use App\Book;
use App\CloudQuery;
use App\LocalQuery;
use DB;
use Faker\Generator as Faker;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all()->sortBy('name');

        return view('book/index', [
            'books' => $books,
        ]);
    }

    /**
     * Random the author column
     */
    public function random(Faker $faker)
    {
        DB::enableQueryLog();

        DB::beginTransaction();

        try
        {
            Book::where('id', '>=', '1')->update(['author' => $faker->name]);
            Book::where('id', '>=', '1')->update(['author' => $faker->name]);

            $query = DB::getQueryLog();
            $sql = '';
            $i = 0;
            foreach($query as $q)
            {
                $j = 0;
                foreach($query[$i]['bindings'] as $qb)
                {
                    $query[$i]['bindings'][$j] = "'" . $query[$i]['bindings'][$j] . "'";
                    $j++;
                }
                $i++;
            }

            $i = 0;
            foreach($query as $q)
            {
                $sql .= str_replace_array('?', $query[$i]['bindings'], $query[$i]['query']) . '; ';
                $i++;
            }

            if(env('APP_ENV', 'local') == 'local')
            {
                LocalQuery::create([
                    'created_at' => now(),
                    'query' => $sql,
                    'uploaded_at' => NULL,
                ]);
            }
            elseif(env('APP_ENV', 'local') == 'cloud')
            {
                CloudQuery::create([
                    'created_at' => now(),
                    'query' => $sql,
                    'executed_at' => NULL,
                ]);
            }

            DB::commit();
            return redirect()->action('BookController@index');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            throw($e);
        }

        DB::disableQueryLog();
    }
}

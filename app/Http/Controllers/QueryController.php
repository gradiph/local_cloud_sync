<?php

namespace App\Http\Controllers;

use App\CloudQuery;
use App\Http\Requests\QueryExecuteRequest;
use App\Http\Requests\QueryGetRequest;
use App\Http\Requests\QuerySetExecutedRequest;
use App\Http\Requests\QuerySetUploadedRequest;
use App\LocalQuery;
use DB;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * execute query in parameter
     */
    public function execute(QueryExecuteRequest $request)
    {
        //receive input
        $query = $request->query;

        DB::beginTransaction();

        try
        {
            //execute the query
            DB::unprepared("update `books` set `author` = 'Isabell Stamm V', `updated_at` = '2018-09-11 19:34:38' where `id` >= '1'; update `books` set `author` = 'Isabell Stamm V', `updated_at` = '2018-09-11 19:34:38' where `id` >= '1';");

            DB::commit();
            return 'success';
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * get query
     */
    public function get(QueryGetRequest $request)
    {
        //get input
        $type = $request->input('type');
        $option = $request->input('option');

        //initialize
        $queries = NULL;

        //get query
        if($type === 'cloud')
        {
            if($option === 'not executed')
            {
                $queries = CloudQuery::whereNull('executed_at')
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }
        elseif($type === 'local')
        {
            if($option === 'not uploaded')
            {
                $queries = LocalQuery::whereNull('uploaded_at')
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }

        return $queries;
    }

    /**
     * set uploaded column of LocalQuery
     */
    public function setUploaded(QuerySetUploadedRequest $request)
    {
        //get input
        $local_query = LocalQuery::find($request->input('local_query_id'));

        $local_query->uploaded_at = now();
        if($local_query->save())
        {
            return 'success';
        }

        return 'failed';
    }

    /**
     * set executed column of CloudQuery
     */
    public function setExecuted(QuerySetExecutedRequest $request)
    {
        //get input
        $cloud_query = CloudQuery::find($request->input('cloud_query_id'));

        $cloud_query->executed_at = now();
        if($cloud_query->save())
        {
            return 'success';
        }

        return 'failed';
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class SearchController
 * @package App\Http\Controllers\Api
 */
class SearchController extends Controller
{
    /**
     * @var mixed
     */
    protected $query;

    /**
     * SearchController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->query = $request->query->get('q');
    }

    /**
     * @param $table
     * @param int $limit
     * @return mixed
     */
    protected function search($table, $limit = 20)
    {
        $results = DB::table($table)
            ->where('email', 'LIKE', "%{$this->query}%")
            ->limit($limit)
            ->get();

        return $results;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
    {
        $users = $this->search('users');

        return response()->json([
            'data' => compact('users') ,
            'status' => 'success',
            'message' => '',
        ]);
    }
}

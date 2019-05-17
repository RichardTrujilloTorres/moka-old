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
    protected function search($table, $field, $limit = 20)
    {
        // TODO add multiple field support
        $results = DB::table($table)
            ->where($field, 'LIKE', "%{$this->query}%")
            ->limit($limit)
            ->get();

        return $results;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
    {
        $users = $this->search('users', 'email');

        return response()->json([
            'data' => compact('users') ,
            'status' => 'success',
            'message' => '',
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles()
    {
        $roles = $this->search('roles', 'name');

        return response()->json([
            'data' => compact('roles') ,
            'status' => 'success',
            'message' => '',
        ]);
    }
}

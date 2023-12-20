<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\MySQLService;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="MySQL Operations",
 *     description="Endpoints for MySQL operations"
 * )
 */
class MySQLController extends Controller
{
    protected $mySQLService;


    public function __construct(MySQLService $mySQLService)
    {
        $this->mySQLService = $mySQLService;
    }



    public function executeQuery(Request $request): JsonResponse
    {
        $mysqlHost = $request->input('mysql_host');
        $mysqlDatabase = $request->input('mysql_database');
        $mysqlUsername = $request->input('mysql_username');
        $mysqlPassword = $request->input('mysql_password');
        $mysqlQuery = $request->input('mysql_query');

        try {
            $results = $this->mySQLService->executeQuery(
                $mysqlHost,
                $mysqlDatabase,
                $mysqlUsername,
                $mysqlPassword,
                $mysqlQuery
            );

            return response()->json(['data' => $results]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

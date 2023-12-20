<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class MySQLService
{
    public function executeQuery($host, $database, $username, $password, $query)
    {

        Config::set('database.connections.mysql_dynamic', [
            'driver' => 'mysql',
            'host' => $host,
            'database' => $database,
            'username' => $username,
            'password' => $password,
        ]);

        try {
            $results = DB::connection('mysql_dynamic')->select($query);

            // Automatic recognition and handling of different table structures
            // Loop through the results to localize numerical values if needed
            foreach ($results as $key => $row) {
                foreach ($row as $columnName => $columnValue) {
                    // Check if the column value is numeric and handle localization
                    if (is_numeric($columnValue)) {
                        // Implement logic to handle numerical localization (e.g., formatting)
                        // For instance, using PHP's number_format function
                        $results[$key]->$columnName = number_format($columnValue, 2, ',', '.');
                    }
                }
            }

            return $results;
        } catch (\Exception $e) {
            // Handle exceptions appropriately or propagate them to the controller
            throw $e;
        }

    }
}

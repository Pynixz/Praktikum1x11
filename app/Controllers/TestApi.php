<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class TestApi extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        // Simple test endpoint
        return $this->respond([
            'status' => 'success',
            'message' => 'API is working!',
            'timestamp' => date('Y-m-d H:i:s'),
            'server_info' => [
                'php_version' => PHP_VERSION,
                'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
                'environment' => ENVIRONMENT
            ]
        ], 200);
    }

    public function test()
    {
        // Test database connection
        try {
            $db = \Config\Database::connect();
            $query = $db->query("SELECT 1 as test");
            $result = $query->getRow();
            
            return $this->respond([
                'status' => 'success',
                'message' => 'Database connection successful',
                'database_test' => $result,
                'timestamp' => date('Y-m-d H:i:s')
            ], 200);
        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ], 500);
        }
    }
}

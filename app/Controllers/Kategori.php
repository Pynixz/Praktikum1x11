<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KategoriModel;

class Kategori extends ResourceController
{
    use ResponseTrait;

    // Handle OPTIONS request for CORS preflight
    public function options()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        return $this->response->setStatusCode(200);
    }

    // GET /kategori
    public function index()
    {
        // Add CORS headers manually as backup
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new KategoriModel();
        $data = $model->orderBy('nama_kategori', 'ASC')->findAll();

        return $this->respond(['kategori' => $data], 200);
    }

    // POST /kategori
    public function create()
    {
        // Add CORS headers
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new KategoriModel();

        // Log request for debugging
        log_message('info', 'Kategori create request received');
        log_message('info', 'Request method: ' . $this->request->getMethod());
        log_message('info', 'Content type: ' . $this->request->getHeaderLine('Content-Type'));

        // Handle JSON data
        $json = $this->request->getJSON();
        log_message('info', 'JSON data: ' . json_encode($json));

        if (!$json || !isset($json->nama_kategori)) {
            log_message('error', 'Invalid JSON data or missing nama_kategori');
            return $this->fail('Data tidak valid atau nama_kategori tidak ada');
        }

        $namaKategori = trim($json->nama_kategori);
        if (empty($namaKategori)) {
            return $this->fail('Nama kategori tidak boleh kosong');
        }

        $data = [
            'nama_kategori' => $namaKategori,
            'slug_kategori' => url_title($namaKategori, '-', true)
        ];

        log_message('info', 'Data to insert: ' . json_encode($data));

        try {
            $insertId = $model->insert($data);
            if ($insertId) {
                log_message('info', 'Kategori inserted with ID: ' . $insertId);
                $data['id_kategori'] = $insertId;
                return $this->respondCreated([
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Kategori berhasil ditambahkan.'
                    ],
                    'data' => $data
                ]);
            } else {
                log_message('error', 'Insert failed, no ID returned');
                return $this->fail('Gagal menambahkan kategori - insert failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'Database error: ' . $e->getMessage());
            return $this->fail('Database error: ' . $e->getMessage());
        }
    }

    // GET /kategori/{id}
    public function show($id = null)
    {
        // Add CORS headers
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new KategoriModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data, 200);
        }

        return $this->failNotFound('Kategori tidak ditemukan.');
    }

    // PUT /kategori/{id}
    public function update($id = null)
    {
        // Add CORS headers
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new KategoriModel();

        // Check if category exists
        $existingKategori = $model->find($id);
        if (!$existingKategori) {
            return $this->failNotFound('Kategori tidak ditemukan untuk diubah.');
        }

        // Handle JSON data
        $json = $this->request->getJSON();

        if (!$json) {
            return $this->fail('Data tidak valid');
        }

        $data = [
            'nama_kategori' => $json->nama_kategori ?? '',
            'slug_kategori' => url_title($json->nama_kategori ?? '', '-', true)
        ];

        if ($model->update($id, $data)) {
            return $this->respond([
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Kategori berhasil diubah.'
                ],
                'data' => $data
            ]);
        }

        return $this->fail('Gagal mengubah kategori.');
    }

    // DELETE /kategori/{id}
    public function delete($id = null)
    {
        // Add CORS headers
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new KategoriModel();

        $kategori = $model->find($id);
        if ($kategori) {
            $model->delete($id);
            return $this->respondDeleted([
                'status'  => 200,
                'error'   => null,
                'messages' => [
                    'success' => 'Kategori berhasil dihapus.'
                ]
            ]);
        }

        return $this->failNotFound('Kategori tidak ditemukan untuk dihapus.');
    }
}

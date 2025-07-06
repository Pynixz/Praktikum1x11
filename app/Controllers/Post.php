<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // GET /post
    public function index()
    {
        // Add CORS headers manually as backup
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        $model = new ArtikelModel();
        $data = $model->getArtikelDenganKategori(); // Menggunakan method yang sudah ada

        return $this->respond(['artikel' => $data], 200);
    }

    // POST /post
    // POST /post
    public function create()
    {
        $model = new ArtikelModel();

        // Debug: Log request details
        log_message('debug', 'POST request received');
        log_message('debug', 'Content-Type: ' . $this->request->getHeaderLine('Content-Type'));
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

        // Check if request has form data (either from multipart or regular POST)
        $hasFormData = $this->request->getPost('judul') !== null ||
                       $this->request->getFile('gambar') !== null ||
                       (strpos($this->request->getHeaderLine('Content-Type'), 'multipart/form-data') !== false);

        if ($hasFormData) {
            // Handle form data with file upload
            $data = [
                'judul'      => $this->request->getPost('judul') ?? '',
                'isi'        => $this->request->getPost('isi') ?? '',
                'status'     => $this->request->getPost('status') ?? 0,
                'id_kategori' => $this->request->getPost('id_kategori') ?? null,
            ];

            log_message('debug', 'Form data: ' . json_encode($data));

            // Handle file upload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->fail('File harus berupa gambar (JPEG, PNG, GIF)');
                }

                // Validate file size (max 2MB)
                if ($file->getSize() > 2048000) {
                    return $this->fail('Ukuran file maksimal 2MB');
                }

                // Generate unique filename
                $fileName = $file->getRandomName();

                // Move file to public/gambar directory
                if ($file->move(FCPATH . 'gambar', $fileName)) {
                    $data['gambar'] = $fileName;
                } else {
                    return $this->fail('Gagal mengupload gambar');
                }
            }

        } else {
            // Handle JSON data (existing functionality)
            $json = $this->request->getJSON();

            if (!$json) {
                return $this->fail('Data tidak valid');
            }

            $data = [
                'judul'      => $json->judul ?? '',
                'isi'        => $json->isi ?? '',
                'status'     => $json->status ?? 0,
                'id_kategori' => $json->id_kategori ?? null,
            ];
        }

        try {
            if ($model->insert($data)) {
                return $this->respondCreated([
                    'status' => 201,
                    'error' => null,
                    'messages' => [
                        'success' => 'Data artikel berhasil ditambahkan.'
                    ],
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            return $this->fail('Database error: ' . $e->getMessage());
        }

        // Get validation errors if any
        $errors = $model->errors();
        if (!empty($errors)) {
            return $this->fail('Validation errors: ' . implode(', ', $errors));
        }

        return $this->fail('Gagal menambahkan artikel.');
    }


    // GET /post/{id}
    public function show($id = null)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data, 200);
        }

        return $this->failNotFound('Data tidak ditemukan.');
    }


    public function update($id = null)
    {
        $model = new ArtikelModel();

        // Check if article exists
        $existingArticle = $model->find($id);
        if (!$existingArticle) {
            return $this->failNotFound('Data tidak ditemukan untuk diubah.');
        }

        // Check if request has form data (either from multipart or regular POST)
        $hasFormData = $this->request->getPost('judul') !== null ||
                       $this->request->getFile('gambar') !== null ||
                       (strpos($this->request->getHeaderLine('Content-Type'), 'multipart/form-data') !== false);

        if ($hasFormData) {
            // Handle form data with file upload
            $data = [
                'judul'      => $this->request->getPost('judul') ?? '',
                'isi'        => $this->request->getPost('isi') ?? '',
                'status'     => $this->request->getPost('status') ?? 0,
                'id_kategori' => $this->request->getPost('id_kategori') ?? null,
            ];

            // Handle file upload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->fail('File harus berupa gambar (JPEG, PNG, GIF)');
                }

                // Validate file size (max 2MB)
                if ($file->getSize() > 2048000) {
                    return $this->fail('Ukuran file maksimal 2MB');
                }

                // Delete old image if exists
                if (!empty($existingArticle['gambar']) && file_exists(FCPATH . 'gambar/' . $existingArticle['gambar'])) {
                    unlink(FCPATH . 'gambar/' . $existingArticle['gambar']);
                }

                // Generate unique filename
                $fileName = $file->getRandomName();

                // Move file to public/gambar directory
                if ($file->move(FCPATH . 'gambar', $fileName)) {
                    $data['gambar'] = $fileName;
                } else {
                    return $this->fail('Gagal mengupload gambar');
                }
            }

        } else {
            // Handle JSON data (existing functionality)
            $json = $this->request->getJSON();

            if (!$json) {
                return $this->fail('Data tidak valid');
            }

            $data = [
                'judul'      => $json->judul ?? '',
                'isi'        => $json->isi ?? '',
                'status'     => $json->status ?? 0,
                'id_kategori' => $json->id_kategori ?? null,
            ];
        }

        if ($model->update($id, $data)) {
            return $this->respond([
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data artikel berhasil diubah.'
                ],
                'data' => $data
            ]);
        }

        return $this->fail('Gagal mengubah artikel.');
    }


    // DELETE /post/{id}
    public function delete($id = null)
    {
        $model = new ArtikelModel();

        $article = $model->find($id);
        if ($article) {
            // Delete associated image file if exists
            if (!empty($article['gambar']) && file_exists(FCPATH . 'gambar/' . $article['gambar'])) {
                unlink(FCPATH . 'gambar/' . $article['gambar']);
            }

            $model->delete($id);
            return $this->respondDeleted([
                'status'  => 200,
                'error'   => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ]);
        }

        return $this->failNotFound('Data tidak ditemukan untuk dihapus.');
    }
}
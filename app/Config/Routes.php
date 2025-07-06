<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================
// 🔧 Default Route
// ========================
$routes->get('/', 'Page::home');

// ========================
// 📦 Public Route untuk Artikel
// ========================
$routes->get('artikel', 'Artikel::index'); // <-- ini tambahan agar /artikel bisa diakses publik

// ========================
// 🔐 Admin Routes (with auth filter)
// ========================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Artikel routes
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// ========================
// 📘 Static Pages
// ========================
$routes->get('about', 'Page::about');
$routes->get('contact', 'Page::contact');
$routes->get('faqs', 'Page::faqs');
$routes->get('tos', 'Page::tos');

// ========================
// 👤 User Authentication
// ========================
$routes->get('user/login', 'User::login');      // Tampilkan form login
$routes->post('user/login', 'User::login');     // Proses form login
$routes->get('user/logout', 'User::logout');    // Logout

// ========================
// 📘 Artikel Public Detail
// ========================
$routes->get('article', 'Artikel::index');
$routes->get('article/(:segment)', 'Artikel::view/$1');

// ========================
// ✅ Test API Endpoints
// ========================
$routes->get('test-api', 'TestApi::index');
$routes->get('test-api/test', 'TestApi::test');

// ========================
// ✅ RESTful API untuk Post Controller
// ========================
$routes->resource('post');

// ========================
// ✅ RESTful API untuk Kategori Controller
// ========================
$routes->resource('kategori');

// ========================
// 🌐 CORS OPTIONS Routes
// ========================
$routes->options('kategori', 'Kategori::options');
$routes->options('kategori/(:any)', 'Kategori::options');
$routes->options('post', 'Post::options');
$routes->options('post/(:any)', 'Post::options');

// ========================
// 🚨 404 Override & Default Settings
// ========================
$routes->set404Override();
$routes->setAutoRoute(false); // Set true jika kamu ingin gunakan auto-routing (tidak disarankan)

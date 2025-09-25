<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Mengarahkan ke tampilan yang menampilkan 3 kategori (Roti, Pastry, Coffee)
        return view('menu.categories');
    }

    public function showCategory($category)
    {
        // Mengambil menu berdasarkan kategori
        $menus = Menu::where('category', $category)->get();
        // Mengarahkan ke tampilan untuk daftar menu per kategori
        return view('menu.category', compact('menus', 'category'));
    }
}
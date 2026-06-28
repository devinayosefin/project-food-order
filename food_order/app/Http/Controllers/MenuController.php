<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Untuk halaman admin kelola menu dan stok
    public function index()
    {
        // Jika user adalah admin, tampilkan admin.menu
        if (auth()->check() && auth()->user()->role_id == 1) {
            $menus = Menu::all();
            return view('admin.menu', compact('menus'));
        }
        // Jika user customer, tampilkan customer_menu.blade.php dengan kategori
        $menus = Menu::all();
        $categories = Menu::select('category')->distinct()->pluck('category');
        return view('customer_menu', compact('menus', 'categories'));
    }

    public function showCategory($category)
    {
    // Mengambil menu berdasarkan kategori (tidak case sensitive)
    $menus = Menu::whereRaw('LOWER(category) = ?', [strtolower($category)])->get();
    // Mengarahkan ke tampilan untuk daftar menu per kategori
    return view('menu.category', compact('menus', 'category'));
    }
    // Hapus menu dari database
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $menu->delete();
            return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
        }
        return redirect()->route('admin.menu.index')->with('success', 'Menu tidak ditemukan!');
    }
}
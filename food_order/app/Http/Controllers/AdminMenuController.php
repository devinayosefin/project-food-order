<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    // Kelola menu dan stok
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Tambah menu
    public function create()
    {
        return view('admin.create_menu');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required',
            'image' => 'nullable|image',
        ]);
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }
        Menu::create($data);
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    // Edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.edit_menu', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category' => 'required',
            'image' => 'nullable|image',
        ]);
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }
        $menu->update($data);
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }
}

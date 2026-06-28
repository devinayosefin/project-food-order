
<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminReportController;

// Halaman Utama (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman History Pembelian User
Route::get('/history', [HomeController::class, 'history'])->name('history');

// Route cart.update
Route::post('/cart/update', [CheckoutController::class, 'updateCart'])->name('cart.update');
// Halaman Utama (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman History Pembelian User
Route::get('/history', [HomeController::class, 'history'])->name('history');

// Halaman Admin - Kelola Menu dan Stok
Route::get('/admin/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('admin.menu.index');

// Halaman Edit Menu (Admin)
Route::get('/admin/menu/{id}/edit', function($id) {
	$menu = null;
	if (class_exists('App\\Models\\Menu')) {
		$menu = App\Models\Menu::find($id);
	}
	return view('admin.edit_menu', compact('menu'));
})->name('admin.menu.edit');

// Proses update menu (admin) - tambahkan di bawah ini
Route::put('/admin/menu/{id}', [App\Http\Controllers\AdminMenuController::class, 'update'])->name('admin.menu.update');

// Proses hapus menu (admin)
Route::delete('/admin/menu/{id}', [App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');

// Halaman Register
// Cashier
Route::get('/cashier', [CashierController::class, 'dashboard'])->name('cashier.dashboard');
Route::get('/cashier/order/{id}', [CashierController::class, 'show'])->name('cashier.order.show');
Route::post('/cashier/order/{id}/update-status', [CashierController::class, 'updateStatus'])->name('cashier.order.updateStatus');

// Admin Menu
Route::get('/admin/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
Route::post('/admin/menu', [AdminMenuController::class, 'store'])->name('admin.menu.store');

// Admin Report
Route::get('/admin/report', [AdminReportController::class, 'index'])->name('admin.report');
Route::get('/register', function() {
	return view('register');
})->name('register');

use Illuminate\Http\Request;

Route::post('/register', function(Illuminate\Http\Request $request) {
	$data = $request->validate([
		'name' => 'required',
		'username' => 'required|unique:users,username',
		'email' => 'required|email|unique:users,email',
		'address' => 'required',
		'phone_number' => 'required',
		'password' => 'required|min:6|confirmed',
	]);
	$user = \App\Models\User::create([
		'email' => $data['email'],
		'username' => $data['username'],
		'password' => bcrypt($data['password']),
		'role_id' => 3, // 3 = customer
	]);
	\App\Models\Customer::create([
		'user_id' => $user->user_id,
		'name' => $data['name'],
		'address' => $data['address'],
		'phone_number' => $data['phone_number'],
	]);
	return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
})->name('register');

// Halaman Login
use Illuminate\Support\Facades\Auth;
// Pastikan hanya menggunakan Request dari parameter closure

Route::get('/login', function() {
	return view('login');
})->name('login');

Route::post('/login', function(Request $request) {
	$credentials = $request->only('email', 'password');
	$user = \App\Models\User::where('email', $credentials['email'])->first();
	if (!$user) {
		return back()->withErrors(['email' => 'Email belum terdaftar, silahkan register.']);
	}
	if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
		return back()->withErrors(['password' => 'Password Salah!']);
	}
	Auth::login($user);
	if ($user->role_id == 1) {
		return redirect()->route('admin.menu.index');
	} elseif ($user->role_id == 2) {
		return redirect()->route('cashier.dashboard');
	} else {
		return redirect()->route('home');
	}
})->name('login');

Route::post('/logout', function() {
	Auth::logout();
	return redirect()->route('home');
})->name('logout');

// Halaman Menu (Menampilkan 3 Kategori)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Halaman Kategori Spesifik (Menampilkan daftar menu per kategori)
Route::get('/menu/{category}', [MenuController::class, 'showCategory'])->name('menu.category');

// Rute Keranjang & Checkout
Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CheckoutController::class, 'showCart'])->name('cart.show');
Route::post('/cart/remove', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/receipt/{order_id}', [CheckoutController::class, 'showReceipt'])->name('receipt');
<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\Karyawan\BarangKeluarController;
use App\Http\Controllers\Karyawan\BarangMasukController;
use App\Http\Controllers\tables\Basic as TablesBasic;

// Main Page Route
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::post('/', [LoginBasic::class, 'store']);
    // Route::get('/register', [RegisterBasic::class, 'index'])->name('auth-register-basic');
    // Route::post('/register', [RegisterBasic::class, 'store']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => 'role:Admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // layout
        Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
        Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
        Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
        Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
        Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

        // pages
        Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
        Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
        Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
        Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
        Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

        // authentication
        Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
        Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
        Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

        // cards
        Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

        // User Interface
        Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
        Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
        Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
        Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
        Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
        Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
        Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
        Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
        Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
        Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
        Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
        Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
        Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
        Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
        Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
        Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
        Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
        Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

        // extended ui
        Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
        Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

        // icons
        Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

        // form elements
        Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
        Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

        // form layouts
        Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
        Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

        // tables
        Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
    });

    Route::group(['middleware' => 'role:Karyawan'], function () {
        Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
        Route::get('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaru'])->name('barang-masuk.barang-baru');
        Route::post('/barang-masuk/barang-baru', [BarangMasukController::class, 'barangBaruStore'])->name('barang-masuk.barang-baru.store');
        Route::get('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersedia'])->name('barang-masuk.barang-tersedia');
        Route::post('/barang-masuk/barang-tersedia', [BarangMasukController::class, 'barangTersediaStore'])->name('barang-masuk.barang-tersedia.store');

        Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    });
    Route::post('/logout', [LoginBasic::class, 'destroy']);
});

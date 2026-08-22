<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CareerApplicationController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestiController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\EmployeePanelController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/employee/login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
Route::post('/employee/login', [EmployeeAuthController::class, 'login'])->name('employee.login.submit');
Route::post('/employee/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');

Route::prefix('employee')->middleware('employee.auth')->group(function () {
    Route::get('/panel', [EmployeePanelController::class, 'index'])->name('employee.panel');
    Route::post('/clock-in', [EmployeePanelController::class, 'clockIn'])->name('employee.clock-in');
    Route::post('/clock-out', [EmployeePanelController::class, 'clockOut'])->name('employee.clock-out');
    Route::post('/reset-password', [EmployeePanelController::class, 'requestPasswordReset'])->name('employee.reset-password');
});

// Frontend Routes
Route::get('/', [IndexController::class, 'home'])->name('home');

// Services page
Route::get('/services', [IndexController::class, 'services'])->name('services');

// About page
Route::get('/about', function () {
    return view('front.pages.about');
})->name('about');

// Team page
Route::get('/team', [IndexController::class, 'team'])->name('team');

// Gallery page
Route::get('/gallery', [IndexController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{id}', [IndexController::class, 'galleryDetail'])->name('gallery.detail');

// Contact page
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
// Contact form submission (alternate route name)
Route::post('/contact/submit', [ContactController::class, 'store'])->name('contact.submit');
// Contact form submission

// Career page
Route::get('/career', [IndexController::class, 'careers'])->name('career');

// Career application submission
Route::post('/career/apply', [CareerController::class, 'apply'])->name('career.apply');

// Testimonials page
Route::get('/testimonials', [IndexController::class, 'testimonials'])->name('testimonials');

Route::prefix('admin')->middleware('auth')->group(function () {

    // Contact Messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
    Route::get('/contact-messages/data', [ContactMessageController::class, 'getData'])->name('admin.contact-messages.data');
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
    Route::put('/contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('admin.contact-messages.update-status');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');

    // Career Applications
    Route::get('/career-applications', [CareerApplicationController::class, 'index'])->name('admin.career-applications.index');
    Route::get('/career-applications/{careerApplication}', [CareerApplicationController::class, 'show'])->name('admin.career-applications.show');
    Route::delete('/career-applications/{careerApplication}', [CareerApplicationController::class, 'destroy'])->name('admin.career-applications.destroy');
    Route::get('/career-applications/{careerApplication}/download-resume', [CareerApplicationController::class, 'downloadResume'])->name('admin.career-applications.download-resume');

    // User Management (Super Admin only)
    Route::middleware('super.admin')->group(function () {
        Route::get('/', function () {
            return redirect()->route('teams.index');
        });
        // Service
        Route::resource('services', ServiceController::class);

        // Team
        Route::resource('teams', TeamController::class);

        // Career
        Route::resource('careers', AdminCareerController::class);

        // Testimonial
        Route::resource('testimonials', TestiController::class);

        // Gallery
        Route::resource('galleries', GalleryController::class);

        // Settings
        Route::get('settings/index', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::get('settings/meta', [SettingController::class, 'meta'])->name('admin.settings.meta');
        Route::post('settings/meta', [SettingController::class, 'updateMeta'])->name('admin.settings.update.meta');
        Route::match(['GET', 'POST'], 'settings/contact', [SettingController::class, 'contact'])->name('admin.settings.contact');
        Route::get('settings/home', [SettingController::class, 'homeSettings'])->name('admin.settings.home');
        Route::post('settings/home', [SettingController::class, 'updateHomeSettings'])->name('admin.settings.home.update');
        Route::get('settings/site-content', [SiteContentController::class, 'edit'])->name('admin.settings.site-content');
        Route::post('settings/site-content', [SiteContentController::class, 'update'])->name('admin.settings.site-content.update');
        Route::post('settings/site-content/upload', [SiteContentController::class, 'upload'])->name('admin.settings.site-content.upload');
        Route::match(['GET', 'POST'], 'settings/team', [SettingController::class, 'team'])->name('admin.settings.team');
        Route::match(['GET', 'POST'], 'settings/services', [SettingController::class, 'servicesSettings'])->name('admin.settings.services');
        Route::match(['GET', 'POST'], 'settings/about', [SettingController::class, 'aboutSettings'])->name('admin.settings.about');
        Route::get('settings/testimonials', [SettingController::class, 'testimonialSettings'])->name('admin.settings.testimonials');
        Route::post('settings/testimonials', [SettingController::class, 'updateTestimonialSettings'])->name('admin.settings.testimonials.update');
        Route::get('settings/analytics', [SettingController::class, 'analyticsSettings'])->name('admin.settings.analytics');
        Route::post('settings/analytics', [SettingController::class, 'updateAnalyticsSettings'])->name('admin.settings.analytics.update');
        Route::get('settings/change-password', [SettingController::class, 'changePassword'])->name('admin.settings.change-password');
        Route::post('settings/change-password', [SettingController::class, 'updatePassword'])->name('admin.settings.change-password.update');
        Route::get('settings/googlemap', [SettingController::class, 'viewGoogleMapSettings'])->name('admin.settings.googlemap');
        Route::post('settings/googlemap', [SettingController::class, 'saveGoogleMapSettings'])->name('admin.settings.googlemap.save');
        Route::post('settings/about/upload-image', [SettingController::class, 'uploadAboutImage'])->name('admin.settings.about.uploadImage');
        Route::post('settings/home/upload-image', [SettingController::class, 'uploadHomeImage'])->name('admin.settings.home.uploadImage');

        Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/promote', [UserManagementController::class, 'promote'])->name('admin.users.promote');
        Route::post('/users/{user}/demote', [UserManagementController::class, 'demote'])->name('admin.users.demote');

        Route::resource('/employees', EmployeeController::class)->except(['show'])->names('admin.employees');
        Route::post('/employees/{employee}/reset-password', [EmployeeController::class, 'resetPassword'])->name('admin.employees.reset-password');
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('admin.attendance.export');
    });
});

// 404 page (fallback)
Route::fallback(function () {
    return response()->view('front.pages.404', [], 404);
});

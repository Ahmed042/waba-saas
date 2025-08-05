<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\WhatsAppLogController;
use App\Http\Controllers\WhatsappWebhookController;

Route::post('/webhook/whatsapp', [WhatsappWebhookController::class, 'handle']);


// Admin routes (super admin)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('clients', ClientController::class);
    Route::get('/whatsapp-logs', [WhatsAppLogController::class, 'index'])->name('whatsapp-logs.index');
    Route::get('/whatsapp-logs/{id}', [WhatsAppLogController::class, 'show'])->name('whatsapp-logs.show');
});

// Client dashboard route (for Jetstream-style unified login; optional)
Route::prefix('client')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    // Add other client-wide routes if needed
});

// Public welcome route
Route::get('/', function () {
    return view('welcome');
});

// Role-based smart redirect from /dashboard (Jetstream etc.)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }

        abort(403, 'Unauthorized.');
    })->name('dashboard');
});

// Admin client CRUD (deduped)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('admin.clients.store');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('admin.clients.update');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('admin.clients.destroy');
});

// Choose-company picker (public)
Route::get('/choose-company', [App\Http\Controllers\Client\AuthController::class, 'showCompanyPicker'])->name('choose.company');
Route::post('/choose-company', [App\Http\Controllers\Client\AuthController::class, 'handleCompanyPicker'])->name('choose.company.post');

// Company-tenant routes (multi-tenant, session-protected, NO middleware)
Route::group(['prefix' => '{company}'], function () {
    // Public per-company: login, password update
    Route::get('/login', [App\Http\Controllers\Client\AuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('/login', [App\Http\Controllers\Client\AuthController::class, 'login'])->name('client.login.submit');
    Route::get('/update-password', [App\Http\Controllers\Client\AuthController::class, 'showUpdatePasswordForm'])->name('client.password.update');
    Route::post('/update-password', [App\Http\Controllers\Client\AuthController::class, 'updatePassword'])->name('client.password.update.submit');

    // PROTECTED: All tenant app features (NO middleware, do session/company check in controller)
    Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/contacts', [App\Http\Controllers\Client\ContactController::class, 'index'])->name('client.contacts');
    Route::post('/contacts', [App\Http\Controllers\Client\ContactController::class, 'store'])->name('client.contacts.store');
    Route::post('/contacts/import', [App\Http\Controllers\Client\ContactController::class, 'import'])->name('client.contacts.import');
    Route::get('/lists', [App\Http\Controllers\Client\ListController::class, 'index'])->name('client.lists');
    Route::post('/lists', [App\Http\Controllers\Client\ListController::class, 'store'])->name('client.lists.store');
    Route::post('/lists/{list}/add-contacts', [App\Http\Controllers\Client\ListController::class, 'addContacts'])->name('client.lists.add_contacts');
    Route::get('/lists/{list}/contacts', [App\Http\Controllers\Client\ListController::class, 'showContacts'])->name('client.lists.contacts');
    Route::get('/send-message', [App\Http\Controllers\Client\MessageController::class, 'index'])->name('client.send_message');
    Route::post('/send-message', [App\Http\Controllers\Client\MessageController::class, 'send'])->name('client.send_message.send');
    Route::get('/inbox', [App\Http\Controllers\Client\InboxController::class, 'index'])->name('client.inbox');
    Route::get('/inbox/contact/{contact?}', [App\Http\Controllers\Client\InboxController::class, 'index'])->name('client.inbox.chat');
    Route::post('/inbox/contact/{contact}/send', [App\Http\Controllers\Client\MessageController::class, 'send'])->name('client.inbox.chat.send');
    // Bulk send (from send-message page)
Route::post('/send-message', [App\Http\Controllers\Client\MessageController::class, 'sendBulk'])->name('client.send_message.send');

    Route::get('/settings', [App\Http\Controllers\Client\SettingsController::class, 'index'])->name('client.settings');
    // Add other secured, company-specific routes here!
    Route::get('/inbox/contact/{contact}/messages', [App\Http\Controllers\Client\InboxController::class, 'getMessages']);
// Template management
Route::get('/templates', [App\Http\Controllers\Client\TemplateController::class, 'index'])->name('client.templates');
Route::get('/templates/create', [App\Http\Controllers\Client\TemplateController::class, 'create'])->name('client.templates.create');
Route::post('/templates', [App\Http\Controllers\Client\TemplateController::class, 'store'])->name('client.templates.store');
    Route::get('/usage', [App\Http\Controllers\Client\UsageController::class, 'index'])->name('client.usage');

});

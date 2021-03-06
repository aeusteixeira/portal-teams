<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ConfigurationController,
    ContentController,
    DashboardController,
    EmailController,
    GroupController,
    UserController,
    GeneratorTeamsAppController,
    MenuController
};
use App\Models\Email;
use Illuminate\Mail\Markdown;

Route::get('/', [AuthController::class, 'login'])->name('auth.index');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/signup', [AuthController::class, 'signup'])->name('auth.signup');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password');

// Rotas de configuração do usuário e geração do app
Route::get('first-access', [AuthController::class, 'firstAccess'])->name('auth.first-access');
Route::post('first-access', [AuthController::class, 'firstAccessGenerate'])->name('auth.first-access-generate');
Route::get('first-access/configure', [AuthController::class, 'configure'])->name('auth.configure');
Route::post('first-access/configure', [AuthController::class, 'configureSave'])->name('auth.configure-save');
Route::get('first-access/generate-teams-app', [GeneratorTeamsAppController::class, 'generate'])->name('auth.generate-teams-app');

Route::group(['prefix' => 'app', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('contents', ContentController::class);
    Route::resource('users', UserController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('emails', EmailController::class);
    Route::resource('configurations', ConfigurationController::class);
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::resource('groups', GroupController::class);
    Route::get('/download-teams-app', [GeneratorTeamsAppController::class, 'downloadZipFile'])->name('download-teams-app');
});

// Rota publica para acesso ao app
Route::get('/app/{app_key}', [GeneratorTeamsAppController::class, 'index'])->name('app.index');

Route::get('teste', function () {
    $markdown = new Markdown(view(), config('mail.markdown'));

    return $markdown->render('emails.templates.pattern', [
        'email' => Email::find(2),
    ]);
});

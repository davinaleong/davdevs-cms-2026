<?php

use App\Http\Controllers\Api\Admin\Auth\AdminForcePasswordChangeController;
use App\Http\Controllers\Api\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Api\Admin\Auth\AdminMeController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorRecoveryCodesDownloadController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorRecoveryCodesRegenerateController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorSetupController;
use App\Http\Controllers\Api\Admin\Auth\AdminTwoFactorVerifyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\SendEmailVerificationController;
use App\Http\Controllers\Api\Auth\TwoFactorRecoveryCodesDownloadController;
use App\Http\Controllers\Api\Auth\TwoFactorRecoveryCodesRegenerateController;
use App\Http\Controllers\Api\Auth\TwoFactorSetupController;
use App\Http\Controllers\Api\Auth\TwoFactorVerifyController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\JokesPageController;
use App\Http\Controllers\PostPageController;
use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\JokeController as AdminJokeController;
use App\Http\Controllers\Web\Admin\PostController as AdminPostController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\ArticlesController;
use App\Http\Controllers\Web\Auth\AdminSessionController;
use App\Http\Controllers\Web\Auth\UserSessionController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ToolsController;
use App\Http\Controllers\Web\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Web\User\LikedPostsController;
use App\Http\Controllers\Web\User\SettingsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', HomeController::class)->name('home');
Route::get('/home', HomeController::class);
Route::get('/about', AboutController::class)->name('about');
Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');
Route::get('/articles/{post}', [ArticlesController::class, 'show'])->name('articles.show');
Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');
Route::get('/tools/{post}', [ToolsController::class, 'show'])->name('tools.show');
Route::get('/contact', ContactController::class)->name('contact');

Route::get('/login', [UserSessionController::class, 'loginForm'])->name('login');
Route::post('/login', [UserSessionController::class, 'login'])->name('login.attempt');
Route::get('/register', [UserSessionController::class, 'registerForm'])->name('register');
Route::post('/register', [UserSessionController::class, 'register'])->name('register.attempt');
Route::post('/logout', [UserSessionController::class, 'logout'])->middleware('auth')->name('logout');
Route::view('/forgot-password', 'auth.user.forgot-password')->name('password.request');
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => ['required', 'email']]);

    $status = Password::sendResetLink($request->only('email'));

    return back()->with('status', __($status));
})->middleware('guest')->name('password.email');
Route::view('/reset-password/{token}', 'auth.user.reset-password')->name('password.reset');
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password): void {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        },
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
Route::view('/email/verify', 'auth.user.verify-email')->middleware('auth')->name('verification.notice');
Route::view('/2fa/challenge', 'auth.user.two-factor-challenge')->middleware('auth')->name('two-factor.challenge');

Route::get('/admin/login', [AdminSessionController::class, 'loginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminSessionController::class, 'login'])->name('admin.login');

Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function (): void {
    Route::post('/logout', [AdminSessionController::class, 'logout'])->name('logout');
    Route::get('/force-password-change', [AdminSessionController::class, 'forcePasswordForm'])->name('force-password.form');
    Route::post('/force-password-change', [AdminSessionController::class, 'forcePasswordUpdate'])->name('force-password.update');
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('/posts', AdminPostController::class);
    Route::resource('/jokes', AdminJokeController::class);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/premium', [AdminUserController::class, 'togglePremium'])->name('users.toggle-premium');
    Route::view('/security', 'admin.security')->name('security');
});

Route::prefix('account')->middleware('auth')->name('user.')->group(function (): void {
    Route::get('/dashboard', UserDashboardController::class)->name('dashboard');
    Route::get('/likes', LikedPostsController::class)->name('likes');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::patch('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
});

Route::get('/posts/{post:slug}', [PostPageController::class, 'show'])->name('posts.show');
Route::get('/jokes', JokesPageController::class)->name('jokes.index');

Route::prefix('auth')->group(function (): void {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/logout', LogoutController::class)->middleware('auth');
    Route::get('/me', MeController::class)->middleware('auth');
    Route::post('/email/verification-notification', SendEmailVerificationController::class)
        ->middleware(['auth', 'throttle:6,1']);
    Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('api.verification.verify');
    Route::post('/2fa/setup', TwoFactorSetupController::class)->middleware('auth');
    Route::post('/2fa/verify', TwoFactorVerifyController::class)->middleware('auth');
    Route::post('/2fa/recovery-codes/regenerate', TwoFactorRecoveryCodesRegenerateController::class)->middleware('auth');
    Route::post('/2fa/recovery-codes/download', TwoFactorRecoveryCodesDownloadController::class)->middleware('auth');
});

Route::prefix('admin/auth')->group(function (): void {
    Route::post('/login', AdminLoginController::class);
    Route::middleware('auth:admin')->group(function (): void {
        Route::get('/me', AdminMeController::class);
        Route::post('/force-password-change', AdminForcePasswordChangeController::class);
        Route::post('/2fa/setup', AdminTwoFactorSetupController::class);
        Route::post('/2fa/verify', AdminTwoFactorVerifyController::class);
        Route::post('/2fa/recovery-codes/regenerate', AdminTwoFactorRecoveryCodesRegenerateController::class);
        Route::post('/2fa/recovery-codes/download', AdminTwoFactorRecoveryCodesDownloadController::class);
    });
});

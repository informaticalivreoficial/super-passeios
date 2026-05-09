<?php

use App\Http\Controllers\Web\SiteController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Bookings\BookingForm;
use App\Livewire\Dashboard\Companies\CatCompanies;
use App\Livewire\Dashboard\Companies\Companies;
use App\Livewire\Dashboard\Companies\CompanyForm;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Posts\CatPosts;
use App\Livewire\Dashboard\Posts\Lixeira;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;
use App\Livewire\Dashboard\Reports\Posts as ReportsPosts;
use App\Livewire\Dashboard\Settings;
use App\Livewire\Dashboard\Sitemap\SitemapGenerator;
use App\Livewire\Dashboard\Tours\TourForm;
use App\Livewire\Dashboard\Users\Form;
use App\Livewire\Dashboard\Users\Time;
use App\Livewire\Dashboard\Users\Users;
use App\Livewire\Dashboard\Users\ViewUser;
use App\Livewire\Dashboard\Vessels\VesselForm;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Vessel;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */   
    Route::get('/', [SiteController::class, 'home'])->name('home'); 

    Route::get('/blog/artigo/{slug}', [SiteController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [SiteController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [SiteController::class, 'artigos'])->name('blog.artigos');
    
    // //*************************************** Páginas *******************************************/
    Route::get('/noticia/{slug}', [SiteController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [SiteController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [SiteController::class, 'categoria'])->name('noticia.categoria');

    Route::get('/pagina/{slug}', [SiteController::class, 'page'])->name('pagina');

});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/', Dashboard::class)->name('admin');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');

    Route::prefix('empresas')->middleware('role:super-admin|company')->name('companies.')->group(function () {
        Route::get('/', Companies::class)->name('index');
        Route::get('/cadastrar', CompanyForm::class)->name('create');
        Route::get('/{company}/editar', CompanyForm::class)->name('edit');
        Route::get('/categorias', CatCompanies::class)->name('categories.index');
    });

    Route::prefix('embarcacoes')->middleware('role:super-admin|company')->name('vessels.')->group(function () {
        Route::get('/', Vessel::class)->name('index');
        Route::get('/cadastrar', VesselForm::class)->name('create');
        Route::get('/{vessel}/editar', VesselForm::class)->name('edit');
    });

    Route::prefix('passeios')->middleware('role:super-admin|company')->name('tours.')->group(function () {
        Route::get('/', Tour::class)->name('index');
        Route::get('/cadastrar', TourForm::class)->name('create');
        Route::get('/{tour}/editar', TourForm::class)->name('edit');
    });

    Route::prefix('reservas')->middleware('role:super-admin|company')->name('bookings.')->group(function () {
        Route::get('/', Booking::class)->name('index'); 
        Route::get('/cadastrar', BookingForm::class)->name('create');
        Route::get('/{booking}/editar', BookingForm::class)->name('edit');
    });

    //*********************** Usuários **********************************************/
    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{userId}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view'); 

    //*********************** Posts *********************************************/
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');
    Route::get('/posts/lixeira', Lixeira::class)->name('posts.lixeira');
    Route::get('posts', Posts::class)->name('posts.index');
    Route::get('posts/reports', ReportsPosts::class)->name('posts.reports');         

});

// Authentication routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

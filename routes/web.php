<?php

use App\Http\Controllers\Web\SiteController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\RegisterCompany;
use App\Livewire\Company\Company\CompanyForm as CompanyCompanyForm;
use App\Livewire\Company\Dashboard as CompanyDashboard;
use App\Livewire\Company\Tours\TourForm as ToursTourForm;
use App\Livewire\Company\Tours\TourIndex;
use App\Livewire\Company\User\UserForm;
use App\Livewire\Company\Vessels\VesselForm as VesselsVesselForm;
use App\Livewire\Company\Vessels\VesselIndex;
use App\Livewire\Dashboard\Bookings\BookingForm;
use App\Livewire\Dashboard\Bookings\Bookings;
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
use App\Livewire\Dashboard\Tours\Tours;
use App\Livewire\Dashboard\Users\Form;
use App\Livewire\Dashboard\Users\Time;
use App\Livewire\Dashboard\Users\Users;
use App\Livewire\Dashboard\Users\ViewUser;
use App\Livewire\Dashboard\Vessels\VesselForm;
use App\Livewire\Dashboard\Vessels\Vessels;
use Illuminate\Support\Facades\Route;

Route::get('/cadastro', RegisterCompany::class)->name('register.company');

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

    Route::get('/embarcacao/{slug}', [SiteController::class, 'vessel'])->name('vessel');

    

});

Route::group(['middleware' => ['auth', 'verified', 'role:customer'], 'prefix' => 'minha-conta', 'as' => 'customer.'], function () {
    Route::get('/', CompanyDashboard::class)->name('dashboard');
});

Route::group(['middleware' => ['auth', 'verified', 'role:company'], 'prefix' => 'painel', 'as' => 'company.'], function () {

    Route::get('/', CompanyDashboard::class)->name('dashboard');

    Route::get('editar-empresa/{uuid}', CompanyCompanyForm::class)->name('company.edit');
    Route::get('/cadastrar-empresa', CompanyCompanyForm::class)->middleware('company.not.exists')->name('company.create');
    Route::get('minha-conta/{user}', UserForm::class)->name('company.users.edit');

    Route::get('/gerenciar-embarcacoes', VesselIndex::class)->name('vessels.index');
    Route::get('/cadastrar-embarcacao', VesselsVesselForm::class)->name('vessels.create');
    Route::get('/editar-embarcacao/{vessel}', VesselsVesselForm::class)->name('vessels.edit');

    Route::get('/gerenciar-passeios', TourIndex::class)->name('tours.index');
    Route::get('/cadastrar-passeio', ToursTourForm::class)->name('tours.create');
    Route::get('/editar-passeio/{tour}', ToursTourForm::class)->name('tours.edit');

    Route::prefix('reservas')->middleware('company.created')->name('bookings.')->group(function () {
        Route::get('/', Bookings::class)->name('index'); 
        Route::get('/cadastrar', BookingForm::class)->name('create');
        Route::get('/{booking}/editar', BookingForm::class)->name('edit');
    });

});







Route::group(['middleware' => ['auth', 'verified', 'role:super-admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');

    Route::get('/empresas', Companies::class)->name('companies.index');
    Route::get('/cadastrar', CompanyForm::class)->name('companies.create');
    Route::get('/{company}/editar', CompanyForm::class)->name('companies.edit');

    Route::get('/embarcacoes', Vessels::class)->name('vessels.index');
    Route::get('/cadastrar', VesselForm::class)->name('vessels.create');
    Route::get('/{vessel}/editar', VesselForm::class)->name('vessels.edit');

    Route::get('/passeios', Tours::class)->name('tours.index');
    Route::get('/cadastrar', TourForm::class)->name('tours.create');
    Route::get('/{tour}/editar', TourForm::class)->name('tours.edit');

    Route::get('/reservas', Bookings::class)->name('bookings.index'); 
    Route::get('/cadastrar', BookingForm::class)->name('bookings.create');
    Route::get('/{booking}/editar', BookingForm::class)->name('bookings.edit');   

    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{userId}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{userId}/visualizar', ViewUser::class)->name('users.view'); 

    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');
    Route::get('/posts/lixeira', Lixeira::class)->name('posts.lixeira');
    Route::get('posts', Posts::class)->name('posts.index');
    Route::get('posts/reports', ReportsPosts::class)->name('posts.reports'); 
});

require __DIR__.'/auth.php';

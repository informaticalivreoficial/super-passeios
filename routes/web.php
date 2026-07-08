<?php

use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\BookingVoucherPdfController;
use App\Http\Controllers\Web\CustomerMagicAccessController;
use App\Http\Controllers\Web\SiteController;
use App\Livewire\Auth\RegisterCompany;
use App\Livewire\Company\Booking\BookingForm as BookingBookingForm;
use App\Livewire\Company\Booking\BookingIndex;
use App\Livewire\Company\Booking\BookingShow;
use App\Livewire\Company\Company\CompanyForm as CompanyCompanyForm;
use App\Livewire\Company\Dashboard as CompanyDashboard;
use App\Livewire\Company\Finance\BankAccounts;
use App\Livewire\Company\Finance\Dashboard as FinanceDashboard;
use App\Livewire\Company\Finance\Withdrawals;
use App\Livewire\Company\Notifications\NotificationIndex;
use App\Livewire\Company\Tours\TourDates;
use App\Livewire\Company\Tours\TourForm as ToursTourForm;
use App\Livewire\Company\Tours\TourIndex;
use App\Livewire\Company\User\UserForm;
use App\Livewire\Company\Vessels\VesselForm as VesselsVesselForm;
use App\Livewire\Company\Vessels\VesselIndex;
use App\Livewire\Dashboard\{
    Bookings\BookingForm,
    Companies\CompanyForm,
    Dashboard,
    NotificationsList,
    Posts\CatPosts,
    Posts\Lixeira,
    Posts\PostForm,
    Posts\Posts,
    Reports\Posts as ReportsPosts,
    Settings,
    Sitemap\SitemapGenerator,
    Tours\TourForm,
    Tours\Tours,
    Users\Form,
    Users\Time,
    Users\Users,
    Users\ViewUser,
    Vessels\VesselForm,
    Vessels\Vessels
};
use App\Livewire\Dashboard\Bookings\Bookings;
use App\Livewire\Dashboard\Companies\Companies;
use App\Livewire\Dashboard\Finance\WithdrawalsIndex;
use App\Livewire\Web\Checkout\CheckoutForm as CheckoutCheckoutForm;
use App\Livewire\Web\Customer\FindOrders;
use App\Livewire\Web\Customer\OrderShow;
use App\Livewire\Web\Customer\OrdersIndex;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';


Route::get('/checkout/{tourDate}', CheckoutCheckoutForm::class)->name('checkout');
Route::get('/meus-pedidos', FindOrders::class)->name('customer.orders.find');
Route::get('/meus-pedidos/acessar/{token}', CustomerMagicAccessController::class)->name('customer.orders.access');

Route::middleware(['auth:customer', 'customer.role:client'])->group(function () {
    Route::get('/meus-pedidos/lista', OrdersIndex::class)->name('customer.orders.index');
    Route::get('/meus-pedidos/{booking:uuid}', OrderShow::class)->name('customer.orders.show');
    Route::get('/{booking:uuid}/pdf', BookingVoucherPdfController::class)->name('customer.orders.pdf'); // ✅ novo
    Route::post('/meus-pedidos/logout', function () {
        \Illuminate\Support\Facades\Auth::guard('customer')->logout();
        return redirect()->route('customer.orders.find');
    })->name('customer.orders.logout');
});

Route::name('web.')->group(function () {    

    Route::get('/', [SiteController::class, 'home'])->name('home');
    Route::get('/cadastro', RegisterCompany::class)->name('register.company');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/artigos', [ArticleController::class, 'index'])->name('index');
        Route::get('/categoria/{slug}', [ArticleController::class, 'category'])->name('category');
        Route::get('/artigo/{slug}', [ArticleController::class, 'show'])->name('show');
        Route::get('/pagina/{slug}', [ArticleController::class, 'page'])->name('page');
    });    

    Route::get('/embarcacao/{slug}', [SiteController::class, 'vessel'])->name('vessel'); 
    
    Route::get('/atendimento', [SiteController::class, 'contact'])->name('contact');
    Route::get('/politica-de-privacidade', [SiteController::class, 'privacy'])->name('privacy');
    Route::get('/termos-e-condicoes', [SiteController::class, 'terms'])->name('terms');
    Route::get('/preferencias-de-cookies', [SiteController::class, 'cookies'])->name('cookies');

    Route::get('/newsletter/cancelar/{token}', [SiteController::class, 'unsubscribe'])
        ->name('newsletter.unsubscribe');

    Route::get('/passeios', [SiteController::class, 'tours'])->name('site.tours');

    Route::get('/pesquisar', [SiteController::class, 'search'])->name('site.search');

    Route::get('/empresas', [SiteController::class, 'companies'])->name('site.companies');
    Route::get('/empresas/load-more', [SiteController::class, 'loadMore'])->name('site.companies.load-more');

    // ✅ Restrição para não capturar rotas do sistema
    Route::get('/passeio/{slug}/{uuid}', [SiteController::class, 'tour'])
        ->name('site.tour')
        ->where('slug', '^(?!email|login|cadastro|painel|admin|minha-conta|forgot-password|reset-password)[a-z0-9-]+$');

    Route::get('/empresa/{slug}', [SiteController::class, 'company'])
        ->name('site.company')
        ->where('slug', '^(?!email|login|cadastro|painel|admin|minha-conta|forgot-password|reset-password)[a-z0-9-]+$');
    
        
});

Route::group(['middleware' => ['auth:customer', 'verified', 'role:proprietary'], 'prefix' => 'minha-conta', 'as' => 'customer.'], function () {
    Route::get('/', CompanyDashboard::class)->name('dashboard');
});

Route::group([
    'middleware' => ['auth:customer', 'verified', 'role:proprietary'], 
    'prefix'     => 'painel', 'as' => 'company.'
    ], function () {

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
    Route::get('/passeios-datas/{tour:uuid}', TourDates::class)->name('tours.dates');

    Route::get('/gerenciar-reservas', BookingIndex::class)->name('bookings.index'); 
    Route::get('/cadastrar-reserva', BookingBookingForm::class)->name('bookings.create');
    Route::get('/visualizar-reserva/{booking}', BookingShow::class)->name('bookings.show');
    Route::get('/reserva/{booking}/editar', BookingBookingForm::class)->name('bookings.edit');

    Route::get('/notificacoes', NotificationIndex::class)->name('notifications.index');

    Route::prefix('financeiro')->name('finance.')->group(function () {
        Route::get('/', FinanceDashboard::class)->name('index');
        Route::get('/meus-bancos', BankAccounts::class)->name('banks');
        // Route::get('/relatorios', FinancialReports::class)->name('reports');
        // Route::get('/contratos', Contracts::class)->name('contracts');
        Route::get('/saques', Withdrawals::class)->name('drawals');
    });
});


Route::group(['middleware' => ['auth', 'verified', 'role:super-admin|admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');
    Route::get('notificacoes', NotificationsList::class)->name('notifications.index');

    Route::get('/empresas', Companies::class)->name('companies.index');
    Route::get('/cadastrar-empresa', CompanyForm::class)->name('companies.create');
    Route::get('/empresa/{company}/editar', CompanyForm::class)->name('companies.edit');

    Route::get('/embarcacoes', Vessels::class)->name('vessels.index');
    Route::get('/cadastrar-embarcacao', VesselForm::class)->name('vessels.create');
    Route::get('/embarcacao/{id}/editar', VesselForm::class)->name('vessels.edit');

    Route::get('/passeios', Tours::class)->name('tours.index');
    Route::get('/cadastrar-passeio', TourForm::class)->name('tours.create');
    Route::get('/passeio/{tour}/editar', TourForm::class)->name('tours.edit');

    Route::get('/reservas', Bookings::class)->name('bookings.index'); 
    Route::get('/cadastrar-reserva', BookingForm::class)->name('bookings.create');
    Route::get('/reserva/{booking}/editar', BookingForm::class)->name('bookings.edit');   

    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuario/{userId}/editar', Form::class)->name('users.edit');
    Route::get('usuario/{userId}/visualizar', ViewUser::class)->name('users.view'); 

    Route::get('posts', Posts::class)->name('posts.index');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');
    Route::get('posts/lixeira', Lixeira::class)->name('posts.lixeira');
    Route::get('posts/reports', ReportsPosts::class)->name('posts.reports');
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit'); 

    Route::get('financeiro-saques', WithdrawalsIndex::class)->name('withdrawals.index');
});

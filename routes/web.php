<?php
use Illuminate\Support\Facades\Artisan;
use App\Helpers\MachineHelper;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DarticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntreeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ListedetailsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MethodesController;
use App\Http\Controllers\OperatController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RemboursementController;
use App\Http\Controllers\RemiseController;
use App\Http\Controllers\SortieController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenteController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return 'Caches cleared!';
});
Route::get('/check-auth', function() {
    return [
        'jetstream' => class_exists('Laravel\Jetstream\JetstreamServiceProvider'),
        'fortify' => class_exists('Laravel\Fortify\FortifyServiceProvider'),
        'providers' => array_keys(app()->getProviders()),
    ];
});
Route::get('/debug-routes', function() {
    $routes = [];
    foreach (app('router')->getRoutes()->getRoutes() as $route) {
        if (str_contains($route->uri(), 'login') || str_contains($route->uri(), 'register')) {
            $routes[] = $route->uri();
        }
    }
    return response()->json([
        'jetstream_installed' => class_exists('Laravel\Jetstream\Jetstream'),
        'fortify_installed' => class_exists('Laravel\Fortify\Fortify'),
        'auth_routes' => $routes
    ]);
});
Route::get('/', function () {
    
    return view('welcome');
});
Route::get('/activation', [LicenseController::class, 'form'])->name('activation.form');
Route::post('/activation', [LicenseController::class, 'activate'])->name('activation.submit');
Route::get('lang/{lang}', function ($lang) {
        app()->setLocale($lang);
        // app()->setlocale('en');
        session()->put('locale',$lang);
        return redirect()->route('dashboard');
    })->name('lang');
//Route::group(['middleware'=>['role:super-admin|admin']],function () {
Route::group(['middleware'=>['isAdmin']],function () {
    Route::resource('permissions',App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete',[App\Http\Controllers\PermissionController::class, 'destroy']);
    // Route::post('permissions/create', [PermissionController::class, 'store2']);
    Route::resource('roles',App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete',[App\Http\Controllers\RoleController::class, 'destroy']);
            // ->middleware('permission:delete role');
    Route::get('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions',[App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    // Route::resource('users',App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete',[App\Http\Controllers\UserController::class, 'destroy']);
});
// Route::middleware('isAdmin')->group(function () {
//     Route::prefix('articles')->group(function () {
//         Route::get('/',[ArticleController::class,'index'])->name('articles.index');
//         Route::get('/create-article', [ArticleController::class, 'create'])->name('articles.create');
//         Route::get('/edit-article/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
//     });
// });
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'license', //protège toute l'app
])->group(function () {
    Route::get('/backup-diagnose', [BackupController::class, 'diagnose']);
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard1',[DashboardController::class,'dashboard1'])->name('dashboard1');
    Route::get('/dashboard2',[DashboardController::class,'dashboard2'])->name('dashboard2');
    Route::get('/dashboard3',[DashboardController::class,'dashboard3'])->name('dashboard3');
    Route::get('/dashboard4',[DashboardController::class,'dashboard4'])->name('dashboard4');
    Route::get('/dashboard5',[DashboardController::class,'dashboard5'])->name('dashboard5');
    Route::get('/dashboard6',[DashboardController::class,'dashboard6'])->name('dashboard6');
    Route::get('/tiers',[TierController::class,'index'])->name('tiers');
    Route::prefix('users')->group(function () {
        Route::get('/',[UserController::class,'index'])->name('users.index');
        Route::get('/create-user', [UserController::class, 'create'])->name('users.create');
        Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::prefix('methodes')->group(function () {
        Route::get('/',[MethodesController::class,'index'])->name('methodes.index');
        Route::get('/create-methode', [MethodesController::class, 'create'])->name('methodes.create');
        Route::post('/create-methode', [MethodesController::class, 'store'])->name('methodes.store');
        Route::get('/edit-methode/{methode}', [MethodesController::class, 'edit'])->name('methodes.edit');
        Route::post('/update-methode/{methode}', [MethodesController::class, 'update'])->name('methodes.update');
    });
    Route::prefix('menus')->group(function () {
        Route::get('/',[MenuController::class,'index'])->name('menus.index');
        Route::get('/create-menu', [MenuController::class, 'create'])->name('menus.create');
        Route::get('/edit-menu/{menu}', [MenuController::class, 'edit'])->name('menus.edit');
    });
    Route::prefix('configs')->group(function () {
        Route::get('/',[ConfigController::class,'index'])->name('configs.index');
        // Route::get('/liste-role', [ConfigController::class, 'lrole'])->name('configs.lrole');
        // Route::get('/liste-permission', [ConfigController::class, 'lpermission'])->name('configs.lpermission');
        Route::get('/create-config', [ConfigController::class, 'create'])->name('configs.create');
        Route::get('/create-societe', [ConfigController::class, 'createsoc'])->name('configs.createsoc');
        Route::get('/edit-config/{config}', [ConfigController::class, 'edit'])->name('configs.edit');
        Route::get('/edit-societe/{societe}', [ConfigController::class, 'editsoc'])->name('configs.editsoc');
        Route::get('/societe', [ConfigController::class, 'societe'])->name('configs.societe');
        Route::get('/monnaie', [ConfigController::class, 'monnaie'])->name('configs.monnaie');
        Route::get('/unite', [ConfigController::class, 'unite'])->name('configs.unite');
        Route::get('/create-monnaie', [ConfigController::class, 'createmonnaie'])->name('configs.monnaie.create');
        Route::get('/edit-monnaie/{monnaie}', [ConfigController::class, 'editmonnaie'])->name('configs.monnaie.edit');
        Route::get('/traces', [ConfigController::class, 'traces'])->name('configs.traces');
        Route::get('/destroy-traces', [ConfigController::class, 'destroytraces'])->name('configs.traces.destroy');
        Route::get('/langue', [ConfigController::class, 'langue'])->name('configs.langue');
        Route::get('/stock', [ConfigController::class, 'stock'])->name('configs.stock');
    });
    Route::prefix('stats')->group(function () {
        Route::get('/',[StatController::class,'index'])->name('stats.index');
        Route::get('/methodes',[StatController::class,'methodes'])->name('stats.methodes');
    });
    Route::prefix('operation')->group(function () {
        Route::get('/',[OperationController::class,'index'])->name('operation.index');
        Route::get('/list',[OperationController::class,'list'])->name('operation.list');
        // Route::get('/methodes',[OperationController::class,'methodes'])->name('operation.methodes');
        // Route::get('/ltransfert',[OperationController::class,'ltransfert'])->name('operation.ltransfert');
        Route::get('/edit-operation/{operation}', [OperationController::class, 'edit'])->name('operation.edit');
        Route::get('/sauvegarde_restauration',[OperationController::class,'sauvegarde_restauration'])->name('operation.sauvegarde_restauration');
        Route::get('/restauration',[OperationController::class,'restauration'])->name('operation.restauration');
    });
    Route::prefix('operat')->group(function () {
        Route::get('/',[OperatController::class,'index'])->name('operat.index');
    });
    Route::prefix('ventes')->group(function () {
        Route::get('/',[VenteController::class,'index'])->name('ventes.index');
        Route::get('/create-vente', [VenteController::class, 'create'])->name('ventes.create');
        Route::get('/create-venteg', [VenteController::class, 'createg'])->name('ventes.create_g');
        Route::get('/edit-vente/{vente}', [VenteController::class, 'edit'])->name('ventes.edit');
        Route::get('/print-vente/{vente}', [VenteController::class, 'print'])->name('ventes.print');
    });
    Route::prefix('factures')->group(function () {
        Route::get('/',[FactureController::class,'index'])->name('factures.index');
        Route::get('/print-facture/{facture}',[FactureController::class,'print2'])->name('factures.print2');
        Route::get('/{facture}/print',[FactureController::class,'print'])->name('factures.print');
        Route::get('/detail-facture/{facture}',[FactureController::class,'detail'])->name('factures.detail');
        Route::get('/detail-vente/{vente}',[FactureController::class,'detailv'])->name('factures.detailv');
        Route::get('/pdf-facture/{facture}',[FactureController::class,'pdf2'])->name('factures.pdf2');
        Route::get('/{facture}/pdf',[FactureController::class,'pdf'])->name('factures.pdf');
    });
    Route::prefix('remises')->group(function () {
        Route::get('/',[RemiseController::class,'index'])->name('remises.index');
    });
    Route::prefix('entrees')->group(function () {
        Route::get('/',[EntreeController::class,'index'])->name('entrees.index');
        Route::get('/create-entree', [EntreeController::class, 'create'])->name('entrees.create');
        Route::get('/edit-entree/{entree}', [EntreeController::class, 'edit'])->name('entrees.edit');
    });
    Route::prefix('sorties')->group(function () {
        Route::get('/',[SortieController::class,'index'])->name('sorties.index');
        Route::get('/create-sortie', [SortieController::class, 'create'])->name('sorties.create');
        Route::get('/detail-sortie', [SortieController::class, 'detail'])->name('sorties.detail');
        Route::get('/edit-sortie/{sortie}', [SortieController::class, 'edit'])->name('sorties.edit');
    });
    Route::prefix('articles')->group(function () {
        Route::get('/',[ArticleController::class,'index'])->name('articles.index');
        Route::get('/index0',[ArticleController::class,'index0'])->name('articles.index0');
        Route::get('/inventaire',[ArticleController::class,'inventaire'])->name('articles.inventaire');
        // Route::get('/detail',[ArticleController::class,'detail'])->name('articles.detail');
        Route::get('/create-article', [ArticleController::class, 'create'])->name('articles.create');
        // Route::get('/edit-article/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::get('/edit-article/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
    });
    Route::prefix('clients')->group(function () {
        Route::get('/',[ClientController::class,'index'])->name('clients.index');
        Route::post('/store-client', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/create-client', [ClientController::class, 'create'])->name('clients.create');
        Route::get('/edit-client/{client}', [ClientController::class, 'edit'])->name('clients.edit');
    });
    Route::prefix('paiements')->group(function () {
        Route::get('/',[PaiementController::class,'index'])->name('paiements.index');
        Route::post('/store-paiement', [PaiementController::class, 'store'])->name('paiements.store');
        Route::get('/create-paiement', [PaiementController::class, 'create'])->name('paiements.create');
        Route::get('/edit-paiement/{paiement}', [PaiementController::class, 'edit'])->name('paiements.edit');
    });
    Route::prefix('remboursements')->group(function () {
        Route::get('/',[RemboursementController::class,'index'])->name('remboursements.index');
        Route::post('/store-remboursement', [RemboursementController::class, 'store'])->name('remboursements.store');
        Route::get('/create-remboursement', [RemboursementController::class, 'create'])->name('remboursements.create');
        Route::get('/edit-remboursement/{remboursement}', [RemboursementController::class, 'edit'])->name('remboursements.edit');
    });
    Route::prefix('fournisseurs')->group(function () {
        Route::get('/',[FournisseurController::class,'index'])->name('fournisseurs.index');
        Route::get('/create-fournisseur', [FournisseurController::class, 'create'])->name('fournisseurs.create');
        Route::get('/create-pfournisseur', [FournisseurController::class, 'pcreate'])->name('fournisseurs.pcreate');
        Route::get('/index-pfournisseur', [FournisseurController::class, 'pindex'])->name('fournisseurs.pindex');
        Route::get('/edit-fournisseur/{fournisseur}', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
    });
    Route::prefix('unites')->group(function () {
        Route::get('/',[UniteController::class,'index'])->name('unites.index');
        Route::get('/create-unite', [UniteController::class, 'create'])->name('unites.create');
        Route::get('/edit-unite/{unite}', [UniteController::class, 'edit'])->name('unites.edit');
    });
    Route::prefix('darticles')->group(function () {
        Route::get('/',[DarticleController::class,'index'])->name('darticles.index');
        Route::get('/create-darticle', [DarticleController::class, 'create'])->name('darticles.create');
        // Route::get('/edit-darticle/{darticle}', [DarticleController::class, 'edit'])->name('darticles.edit');
    });
    Route::prefix('listedetails')->group(function () {
        Route::get('/',[ListedetailsController::class,'index'])->name('listedetails.index');
        Route::get('/operation',[ListedetailsController::class,'operation'])->name('listedetails.operation');
    });
    Route::get('/backup', [BackupController::class, 'backup'])->name('backup.create');
    Route::post('/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::get('/test-machine-id', function () {
    return MachineHelper::machineId();
});

});

<?php

declare(strict_types=1);

use App\Http\Controllers\orchid\OrchidImportController;
use App\Orchid\Screens\Basket\BasketListScreen;
use App\Orchid\Screens\Block\BlockEditScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Element\ElementListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Category\CategoryListScreen;
use App\Orchid\Screens\Image\ImageEditScreen;
use App\Orchid\Screens\Images\ImagesEditScreen;
use App\Orchid\Screens\Manufacturer\ManufacturerEditScreen;
use App\Orchid\Screens\Manufacturer\ManufacturerListScreen;
use App\Orchid\Screens\Message\MessageEditScreen;
use App\Orchid\Screens\Message\MessageListScreen;
use App\Orchid\Screens\Order\OrderEditScreen;
use App\Orchid\Screens\Order\OrderListScreen;
use App\Orchid\Screens\Page\PageEditScreen;
use App\Orchid\Screens\Page\PageListScreen;
use App\Orchid\Screens\DashboardScreen;
use App\Orchid\Screens\Product\ProductEditScreen;
use App\Orchid\Screens\Product\ProductListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\SettingsDesign\SettingsDesign;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/dashboard', DashboardScreen::class)
    ->name('platform.dashboard');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn(Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn(Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/form/examples/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/form/examples/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/form/examples/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/form/examples/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/layout/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/charts/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/cards/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

Route::screen('manufacturers', ManufacturerListScreen::class)->name('platform.manufacturer.list');
Route::screen('manufacturers/create', ManufacturerEditScreen::class)->name('platform.manufacturer.create');
Route::screen('manufacturers/{manufacturer}', ManufacturerEditScreen::class)->name('platform.manufacturer.edit');

Route::screen('categories', CategoryListScreen::class)->name('platform.category.list');
Route::screen('categories/create', CategoryEditScreen::class)->name('platform.category.create');
Route::screen('categories/{category}', CategoryEditScreen::class)->name('platform.category.edit');

Route::screen('products', ProductListScreen::class)->name('platform.product.list');
Route::screen('products/create', ProductEditScreen::class)->name('platform.product.create');
Route::screen('products/{product}', ProductEditScreen::class)->name('platform.product.edit');

Route::screen('settings-design', SettingsDesign::class)->name('platform.settings.design');

Route::screen('pages', PageListScreen::class)->name('platform.page.list');
Route::screen('pages/create', PageEditScreen::class)->name('platform.page.create');
Route::screen('pages/{page}', PageEditScreen::class)->name('platform.page.edit');


Route::screen('elements', ElementListScreen::class)->name('platform.element.list');

Route::screen('blocks/create', BlockEditScreen::class)->name('platform.block.create');
Route::screen('blocks/{block}', BlockEditScreen::class)->name('platform.block.edit');

Route::screen('images/create', ImageEditScreen::class)->name('platform.image.create');
Route::screen('images/{image}', ImageEditScreen::class)->name('platform.image.edit');

Route::screen('imagelist/create', ImagesEditScreen::class)->name('platform.imagelist.create');
Route::screen('imagelist/{id}', ImagesEditScreen::class)->name('platform.imagelist.edit');

Route::screen('orders', OrderListScreen::class)->name('platform.order.list');
Route::screen('orders/{order}', OrderEditScreen::class)->name('platform.order.edit');

Route::screen('baskets', BasketListScreen::class)->name('platform.basket.list');
Route::screen('baskets/{customer}', BasketListScreen::class)->name('platform.basket.edit');

Route::screen('messages', MessageListScreen::class)->name('platform.message.list');
Route::screen('messages/{message}', MessageEditScreen::class)->name('platform.message.edit');

Route::get('service/import', [OrchidImportController::class, 'index'])->name('platform.import.view');

// import xls file
Route::post('service/import/uploadxls', [OrchidImportController::class, 'uploadxls'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.uploadxls');
Route::post('service/import/importxls', [OrchidImportController::class, 'importxls'])
    //->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.xls');
Route::get('service/import/statusxls', [OrchidImportController::class, 'importxlsStatus'])
    //->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.statusxls');

// import zip file
Route::post('service/import/uploadchunked', [OrchidImportController::class, 'uploadchunked'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.uploadchunked');
Route::post('service/import/importzip', [OrchidImportController::class, 'importzip'])
    //->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.zip');
Route::get('service/import/statuzip', [OrchidImportController::class, 'importzipStatus'])
    //->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.import.statuszip');
Route::get('service/task/{id}/status', [OrchidImportController::class, 'taskStatus'])
    //->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.task.status');
Route::get('service/task/{id}/log', [OrchidImportController::class, 'taskLog'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('platform.task.log');




//Route::screen('service/import', ImportProductsScreen::class)->name('platform.import.products');
//Route::screen('idea', Idea::class, 'platform.screens.idea');
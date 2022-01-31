<?php

namespace App\Providers;

use App\Http\Resources\PaginationResource;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    private $operations = [
        'order' => 'getOrdersByDateRange',
        'new_order' => 'getOrdersByDateRange',
        'order_today' => 'getOrdersByDateRange',
        'delivered_order' => 'getDeliveredOrdersByDateRange',
        'undelivered_order' => 'getUndeliveredOrders',
        'all_order' => 'getOrdersByDateRange',
        'ssl_response' => 'getOrdersByDateRange',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //add error reporting level
        // ini_set('sys_temp_dir', '/tmp');
        // ini_set('upload_tmp_dir', '/tmp');
        Schema::defaultStringLength(191); // for server issue
        JsonResource::withoutWrapping();
        Order::observe(OrderObserver::class);
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach ($attributes as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });

            return $this;
        });

        $operations = $this->operations;
        View::composer('admin.orders.*', function() use ($operations){
            View::share('operations', $operations);
        });


        $this->setFrontPerpagePagination();
    }

    public function setFrontPerpagePagination()
    {
        $perPagePagination = request('per_page');

        if(isset($perPagePagination) && !empty($perPagePagination) && is_numeric($perPagePagination) && $perPagePagination > 0)
            config(['application.paginatePerPage.front' => request('per_page')]);
    }
}

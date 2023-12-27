<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }


    public function userCountInDayWithPrevDay()
    {
        $today = User::whereDate('created_at', Carbon::today())->get();
        $yesterday = User::whereDate('created_at', Carbon::yesterday())->get();
        $response = ['count' => count($today), 'growth' => $this->getGrowth(count($today), count($yesterday))];

        return response()->json($response);
    }
    public function productCountInDayWithPrevDay()
    {
        $today = Product::whereDate('created_at', Carbon::today())->get();
        $yesterday = Product::whereDate('created_at', Carbon::yesterday())->get();

        $response = ['count' => count($today), 'growth' => $this->getGrowth(count($today), count($yesterday))];

        return response()->json($response);
    }

    public function productProfitInDayWithPrevDay()
    {
        $todayItems = OrderItem::with('product')->whereDate('created_at', Carbon::today())->get();
        $yesterdayItems = OrderItem::with('product')->whereDate('created_at', Carbon::yesterday())->get();

        $temp = 0;
        $todayTotal = $todayItems->reduce(function ($t, $i) {
            return $i->product->price + $t;
        }, $temp);

        $temp = 0;
        $yesterdayTotal = $yesterdayItems->reduce(function ($t, $i) {
            return $i->product->price + $t;
        }, $temp);

        $response = ['total' => round($todayTotal, 2), 'growth' => $this->getGrowth($todayTotal, $yesterdayTotal)];

        return response()->json($response);

    }

    public function getTopProductProfitByDay(Request $request)
    {
        $top = $request->input('top');

        $topRevenueLastQuarter = OrderItem::select(DB::raw('SUM(quantity * price) AS revenueOfLastQuarter, product_id'))
            ->join('products', function (JoinClause $join) {
                $join->on('order_items.product_id', '=', 'products.id');
            })
            ->groupBy('product_id')
            ->whereMonth('order_items.created_at', '>=', Carbon::today()->lastOfQuarter()->month)
            ->whereYear('order_items.created_at', '=', Carbon::today()->year)
            ->orderBy(DB::raw('revenueOfLastQuarter'), 'desc')
            ->take($top)
            ->get();

        $ids = $topRevenueLastQuarter->pluck('product_id');

        $productQuantity = OrderItem::select(DB::raw('COUNT(quantity) AS orderedQuantity, DAY(created_at) AS orderedDate,product_id'))
            ->groupBy('product_id', 'orderedDate')
            ->whereBetween('created_at', [Carbon::today()->firstOfMonth(), Carbon::yesterday()])
            ->whereIn('product_id', $ids)
            ->orderBy(DB::raw('orderedQuantity'));

        $items = DB::table('products')
            ->joinSub($productQuantity, 'productQuantity', function (JoinClause $j) {
                $j->on('products.id', '=', 'productQuantity.product_id');
            })
            ->addSelect(DB::raw('(orderedQuantity * price) as revenue, orderedDate, product_id, name'))
            ->get();

        $itemsOrderByDate = array();
        $temp = $items->pluck('product_id');

        foreach ($temp as $id) {
            $itemsOrderByDate[$id] = array();
        }

        foreach ($items as $item) {
            array_push($itemsOrderByDate[$item->product_id], array("revenue" => $item->revenue, 'date' => $item->orderedDate, 'name' => $item->name));
        }

        $response = array();

        $today = Carbon::today()->day;

        foreach ($itemsOrderByDate as $product) {
            $temp = array();
            $temp['name'] = $product[0]['name'];

            foreach ($product as $prop) {
                $temp['data'][$prop['date']] = round($prop['revenue'], 2);
            }

            for ($i = 0; $i < $today; $i++) {
                if (!isset($temp['data'][$i])) {
                    $temp['data'][$i] = 0;
                }
            }
            ksort($temp['data']);

            $temp['data'] = array_values($temp['data']);
            array_push($response, $temp);
        }

        return response()->json(['series' => $response, 'range' => ['start' => Carbon::today()->firstOfMonth()->isoFormat('DD.MM.YYYY'), 'end' => Carbon::today()->isoFormat('DD.MM.YYYY')]]);
    }

    public function getTopProductProfitByWeek(Request $request)
    {
        $top = $request->input('top');

        $topRevenueLastQuarter = OrderItem::select(DB::raw('SUM(quantity * price) AS revenueOfLastQuarter, product_id'))
            ->join('products', function (JoinClause $join) {
                $join->on('order_items.product_id', '=', 'products.id');
            })
            ->groupBy('product_id')
            ->whereMonth('order_items.created_at', '>=', Carbon::today()->lastOfQuarter()->month)
            ->whereYear('order_items.created_at', '=', Carbon::today()->year)
            ->orderBy(DB::raw('revenueOfLastQuarter'), 'desc')
            ->take($top)
            ->get();

        $ids = $topRevenueLastQuarter->pluck('product_id');

        $productQuantity = OrderItem::select(DB::raw('COUNT(quantity) AS orderedQuantity, WEEK(created_at) AS orderedWeek,product_id'))
            ->groupBy('product_id', 'orderedWeek')
            ->whereBetween('created_at', [Carbon::today()->lastOfMonth()->firstOfMonth(), Carbon::yesterday()])
            ->whereIn('product_id', $ids)
            ->orderBy(DB::raw('orderedQuantity'));

        $items = DB::table('products')
            ->joinSub($productQuantity, 'productQuantity', function (JoinClause $j) {
                $j->on('products.id', '=', 'productQuantity.product_id');
            })
            ->addSelect(DB::raw('(orderedQuantity * price) as revenue, orderedWeek, product_id, name'))
            ->get();

        $itemsOrderByWeek = array();
        $temp = $items->pluck('product_id');

        foreach ($temp as $id) {
            $itemsOrderByWeek[$id] = array();
        }

        foreach ($items as $item) {
            array_push($itemsOrderByWeek[$item->product_id], array("revenue" => $item->revenue, 'week' => $item->orderedWeek, 'name' => $item->name));
        }

        $response = array();

        $end = Carbon::today()->week;
        $start = Carbon::today()->subMonths(1)->firstOfMonth()->week + 1;
        foreach ($itemsOrderByWeek as $product) {
            $temp = array();
            $temp['name'] = $product[0]['name'];

            foreach ($product as $prop) {
                $temp['data'][$prop['week']] = round($prop['revenue'], 2);
            }

            for ($i = $start; $i < $end; $i++) {
                if (!isset($temp['data'][$i])) {
                    $temp['data'][$i] = 0;
                }
            }
            ksort($temp['data']);
            $temp['data'] = array_values($temp['data']);
            array_push($response, $temp);
        }

        return response()->json(['series' => $response, 'range' => ['start' => Carbon::today()->subMonths(1)->firstOfMonth()->isoFormat('DD.MM.YYYY'), 'end' => Carbon::today()->isoFormat('DD.MM.YYYY')]]);
    }

    public function getProductRevenueByCategory(Request $request)
    {
        $groupBy = $request->input('groupBy');

        $query = Product::join('categories_products', 'products.id', '=', 'categories_products.product_id')
            ->join('categories', 'categories_products.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.product_id', '=', 'products.id');

        if ($groupBy == 'day') {
            $query->whereDate('order_items.created_at', '=', Carbon::today());
        } else if ($groupBy == 'month') {
            $query->whereMonth('order_items.created_at', '=', Carbon::today()->month)->whereYear('order_items.created_at', '=', Carbon::today()->year);
        } else {
            $query->whereYear('order_items.created_at', '=', Carbon::today()->year);
        }

        $query->select(DB::raw('categories.name, SUM(order_items.quantity * products.price) as totalRevenue'))
            ->groupBy(['categories_products.category_id', 'categories.name']);

        return response()->json($query->get());
    }

    private function getGrowth($t, $y)
    {
        if ($y == 0 && $t == 0) {
            return 0;
        } else if ($y == 0 && $t != 0) {
            return 100;
        } else if ($y != 0 && $t == 0) {
            return -100;
        } else {
            return round($t / $y * 100, 2);
        }
    }

    public function showProducts(Request $request)
    {
        $page = $request->input('page');

        $products = DB::table('products')->where('number_in_stock', '>', '-1')
            ->orderBy('id', 'desc')
            ->paginate(config('app.pagination.per_page'), ['*'], 'page', $page ?? 1);

        return view('dashboard.product')->with('products', $products);
    }

    public function showUsers(Request $request)
    {
        $page = $request->input('page');
        $users = User::orderBy('created_at')->paginate(config('app.pagination.per_page'), ['*'], 'page', $page ?? 1);

        return view('dashboard.user')->with('users', $users);
    }

    public function showOrders(Request $request)
    {
        $page = $request->input('page');

        $orders = Order::paginate(config('app.pagination.per_page'), ['*'], 'page', $page ?? 1);
        $orders->load('orderItems');

        return view('dashboard.order', compact('orders'));
    }
}

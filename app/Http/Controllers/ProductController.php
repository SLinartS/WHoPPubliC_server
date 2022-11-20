<?php

namespace App\Http\Controllers;

use App\Actions\ProductResponsePrepare;
use App\Models\Category;
use App\Models\LocationHistory;
use App\Models\Product;
use App\Models\ProductFloor;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    public function index(ProductResponsePrepare $productResponsePrepare)
    {
        $products = Product::select('id', 'article', 'title', 'author', 'number', 'print_date')
            ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
            ->get();

        $response = $productResponsePrepare($products);

        return response()->json($response, 200);
    }

    public function getProductsOfTask($taskId,)
    {
        try {
            $taskController = new TaskController;

            $products = Product::select('id', 'article', 'title', 'author', 'year_of_publication', 'number', 'print_date')
                ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
                ->join('products_tasks as PT', 'id', 'PT.product_id')
                ->where('PT.task_id', $taskId)
                ->get();

            $productResponsePrepare = new ProductResponsePrepare;
            if (count($products) > 0) {
                $response = $productResponsePrepare($products);

                return response()->json($response, 200);
            }
            return response('Unknown tasks id', 404);
        } catch (Throwable $th) {
            return response($th, 422);
        }
    }

    public function addProducts(Request $request, ProductFloorController $productFloorController)
    {
        try {
            $products = $request->products;
            $warehousePoints = $request->warehousePoints;

            $productIds = [];
            for ($i = 0; $i < count($products); $i++) {
                $product = new Product;
                $product->article = $products[$i]['article']['value'];
                $product->title = $products[$i]['title']['value'];
                $product->author = $products[$i]['author']['value'];
                $product->year_of_publication = $products[$i]['yearOfPublication']['value'];
                $product->number = $products[$i]['number']['value'];
                $product->print_date = $products[$i]['printDate']['value'];
                $product->printing_house = $products[$i]['printingHouse']['value'];
                $product->publishing_house = $products[$i]['publishingHouse']['value'];
                $product->stored = false;
                $product->user_id = $request->userId;
                $product->category_id = $products[$i]['categoryId']['value'];

                $product->save();

                $productId = Product::select('id')->where('article', $products[$i]['article']['value'])->first()['id'];
                array_push($productIds, $productId);
            }

            $productFloorController->addProductFloorLinks($productIds, $warehousePoints);

            return response()->json([
                'message' => 'The products has been added',
                'productIds' => $productIds
            ], 200);
        } catch (Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
    }

    public function deleteProduct(array $productId)
    {
        try {
            ProductFloor::where('product_id', $productId)->delete();
            LocationHistory::where('product_id', $productId)->delete();
            Product::where('id', $productId)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function deleteProductsByIds(array $productIds)
    {
        try {
            ProductFloor::whereIn('product_id', $productIds)->delete();
            LocationHistory::whereIn('product_id', $productIds)->delete();
            Product::whereIn('id', $productIds)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }
}

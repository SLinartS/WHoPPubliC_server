<?php

namespace App\Http\Controllers;

use App\Actions\ProductResponsePrepare;
use App\Http\Controllers\Utils\ProductUtils;
use App\Models\Category;
use App\Models\LocationHistory;
use App\Models\Product;
use App\Models\ProductFloor;
use App\Models\ProductPoint;
use App\Models\ProductTask;
use Exception;
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

    public function addProducts(
        Request $request,
        ProductPointController $productPointController
    ) {
        try {
            $products = $request->formData;

            $product = new Product;
            $product->article = $products['article']['value'];
            $product->title = $products['title']['value'];
            $product->author = $products['author']['value'];
            $product->year_of_publication = $products['yearOfPublication']['value'];
            $product->number = $products['number']['value'];
            $product->print_date = $products['printDate']['value'];
            $product->printing_house = $products['printingHouse']['value'];
            $product->publishing_house = $products['publishingHouse']['value'];
            $product->user_id = $request->userId;
            $product->category_id = $products['categoryId']['value'];

            $product->save();

            $productId = Product::select('id')->where('article', $products['article']['value'])->first()['id'];

            try {
                $productPointController->addLink($productId, $request->pointId);
            } catch (Throwable $th) {
                throw $th;
            }

            return response()->json([
                'message' => 'The products has been added'
            ], 200);
        } catch (Throwable $th) {
            return response($th, 422);
        }
    }

    public function deleteProduct(string $productId, ProductUtils $productUtils)
    {
        try {
            $productUtils->checkTaskLinkExist($productId);
            ProductTask::where('product_id', $productId)->delete();
            ProductFloor::where('product_id', $productId)->delete();
            LocationHistory::where('product_id', $productId)->delete();
            ProductPoint::where('product_id', $productId)->delete();
            Product::where('id', $productId)->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }
}

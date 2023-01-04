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
        try {
            $products = Product::select(
                'id',
                'article',
                'title',
                'author',
                'year_of_publication',
                'number',
                'print_date',
                'printing_house',
                'publishing_house',
                'category_id'
            )
                ->addSelect(['category_title' => Category::select('title')->whereColumn('id', 'category_id')])
                ->get();


            $idsProductWithLinkToTask = ProductTask::select('product_id', 'task_id')->get();

            $response = $productResponsePrepare($products, $idsProductWithLinkToTask);

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function getOneProduct(int $productId, ProductResponsePrepare $productResponsePrepare)
    {
        try {
            $product = Product::select(
                'id',
                'article',
                'title',
                'author',
                'year_of_publication',
                'number',
                'print_date',
                'printing_house',
                'publishing_house',
                'category_id'
            )
                ->addSelect(['category_title' => Category::select('title')->whereColumn('id', 'category_id')])
                ->addSelect(['point_id' => ProductPoint::select('point_id')->whereColumn('product_id', 'id')->limit(1)])
                ->where('id', $productId)
                ->first();

            $idsProductWithLinkToTask = ProductTask::select('product_id', 'task_id')->get();

            $response = $productResponsePrepare->oneProduct($product, $idsProductWithLinkToTask);

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
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
            $product->is_active = true;

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

    public function updateProduct(
        Request $request,
        ProductPointController $productPointController,
        ProductUtils $productUtils
    ) {
        try {
            $fields = $request->formData;
            $productId = $fields['id']['value'];
            
            $product = Product::where('id', $productId)->first();
            $product->article = $fields['article']['value'];
            $product->title = $fields['title']['value'];
            $product->author = $fields['author']['value'];
            $product->year_of_publication = $fields['yearOfPublication']['value'];
            $product->number = $fields['number']['value'];
            $product->print_date = $fields['printDate']['value'];
            $product->printing_house = $fields['printingHouse']['value'];
            $product->publishing_house = $fields['publishingHouse']['value'];
            $product->user_id = $request->userId;
            $product->category_id = $fields['categoryId']['value'];
            $product->is_active = true;

            $product->save();

            $productUtils->deletAllPointLinks($productId);

            $productId = Product::select('id')->where('article', $fields['article']['value'])->first()['id'];

            try {
                $productPointController->addLink($productId, $request->pointId);
            } catch (Throwable $th) {
                throw $th;
            }

            return response()->json([
                'message' => 'The products has been changed'
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

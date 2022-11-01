<?php

namespace App\Http\Controllers;

use App\Actions\ProductResponsePrepare;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    public function index(ProductResponsePrepare $productResponsePrepare)
    {
        $products = Product::select('id', 'article', 'title', 'author', 'year_of_publication', 'number', 'print_date',)
            ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
            ->get();

        $response = $productResponsePrepare($products);

        return response()->json($response, 200);
    }

    public function getProductsOfTask($taskArticle, ProductResponsePrepare $productResponsePrepare)
    {
        try {
            $taskController = new TaskController;

            $taskId = $taskController->getTaskIdByArticle($taskArticle);
            if ($taskId['error']) {
                return response($taskId['data'], 404);
            }

            $products = Product::select('id', 'article', 'title', 'author', 'year_of_publication', 'number', 'print_date')
                ->addSelect(['category' => Category::select('title')->whereColumn('id', 'category_id')])
                ->join('products_tasks as PT', 'id', 'PT.product_id')
                ->where('PT.task_id', $taskId['data'])
                ->get();

            if (count($products) > 0) {
                $response = $productResponsePrepare($products);

                return response()->json($response, 200);
            }
            return response('Unknown tasks id', 404);
        } catch (Throwable $th) {
            return response($th, 422);
        }
    }

    public function addProduct(Request $request, ProductTaskController $productTaskController)
    {
        try {
            $product = new Product;
            $product->article = $request->article;
            $product->title = $request->title;
            $product->author = $request->author;
            $product->year_of_publication = $request->yearOfPublication;
            $product->number = $request->number;
            $product->print_date = $request->printDate;
            $product->printing_house = $request->printingHouse;
            $product->publishing_house = $request->publishingHouse;
            $product->stored = false;
            $product->user_id = $request->userId;
            $product->category_id = $request->category;

            $product->save();

            $productId = Product::select('id')->where('article', $request->article)->first();

            $error = $productTaskController->addProductTaskLink($request->taskArticle, $productId->id);
            if ($error === false) {
                return response('The product has been added', 200);
            }

            $productId->delete();
            throw new Exception($error);
        } catch (Throwable $th) {
            return response($th->getMessage(), 422);
        }
    }
}

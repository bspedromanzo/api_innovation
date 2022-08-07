<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Mark;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyNewProduct;


class ProductController extends Controller
{
    public function indexProduct()
    {
        return Product::all();
    }

    public function indexCategory()
    {
        return Category::all();
    }

    public function indexMark()
    {
        return Mark::all();
    }

    public function product(Product $product)
    {
        return $product;
    }


    public function category(Category $category)
    {
        return $category;
    }

    public function mark(Mark $mark)
    {
        return $mark;
    }


    public function createProduct(Request $request)
    {
        $create = false;
        $nameValidate = false;
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'value' => 'required',
            'category_id' => 'required',
            'mark_id' => 'required',
            'stock' => 'required'
        ];
        $validator = Validator::make($data, $rules);

        $nameVerify = DB::table('products')
            ->where('name', $request['name'])->first();

        if ($nameVerify == NULL) {
            $nameValidate = true;
        }

        if ($validator->passes()) {
            if (!$nameValidate) {
                $message = \Response::json(['code' => '400', 'message' => "Producto já cadastrado"]);
            } else {
                $create = true;
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "Problemas nos dados cadastrais"]);
        }

        if ($create) {
            $collaborator = [
                'name' => $request['name'],
                'value' => $request['value'],
                'category_id' => $request['category_id'],
                'mark_id' => $request['mark_id'],
                'stock' => $request['stock']
            ];

            Product::create($collaborator);

            $collaboratorValidator = DB::table('collaborators')->where('id', 1)->first();
            if ($collaboratorValidator) {
                Mail::send(new notifyNewProduct($collaboratorValidator));
            } else {
                $message = \Response::json(['code' => '400', 'message' => "E-mail informado não encontrado"]);
            }

            $message = \Response::json(['code' => '200', 'message' => "Produto cadastrado com sucesso"]);
        }



        return $message;
    }

    public function createCategory(Request $request)
    {
        $create = false;
        $nameValidate = false;
        $data = $request->all();
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($data, $rules);

        $nameVerify = DB::table('categories')
            ->where('name', $request['name'])->first();

        if ($nameVerify == NULL) {
            $nameValidate = true;
        }

        if ($validator->passes()) {
            if (!$nameValidate) {
                $message = \Response::json(['code' => '400', 'message' => "Categoria já cadastrado"]);
            } else {
                $create = true;
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "Problemas nos dados cadastrais"]);
        }

        if ($create) {
            $collaborator = [
                'name' => $request['name']
            ];

            Category::create($collaborator);
            $message = \Response::json(['code' => '200', 'message' => "Categoria cadastrada com sucesso"]);
        }

        return $message;
    }

    public function createMark(Request $request)
    {
        $create = false;
        $nameValidate = false;
        $data = $request->all();
        $rules = [
            'name' => 'required'
        ];
        $validator = Validator::make($data, $rules);

        $nameVerify = DB::table('marks')
            ->where('name', $request['name'])->first();

        if ($nameVerify == NULL) {
            $nameValidate = true;
        }

        if ($validator->passes()) {
            if (!$nameValidate) {
                $message = \Response::json(['code' => '400', 'message' => "Marca já cadastrado"]);
            } else {
                $create = true;
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "Problemas nos dados cadastrais"]);
        }

        if ($create) {
            $collaborator = [
                'name' => $request['name']
            ];

            Mark::create($collaborator);
            $message = \Response::json(['code' => '200', 'message' => "Marca cadastrada com sucesso"]);
        }

        return $message;
    }

    public function updateProduct(Request $request)
    {
        $name = isset($request['name']);
        $value = isset($request['value']);
        $category_id = isset($request['category_id']);
        $mark_id = isset($request['mark_id']);
        $id = isset($request['id']);
        $info = [];
        $campo = false;
        $message = "";

        if ($id) {
            if ($name) {
                $info['name'] = $request['name'];
                $campo = true;
            }

            if ($value) {
                $info['value'] = $request['value'];
                $campo = true;
            }

            if ($category_id) {
                $info['category_id'] = $request['category_id'];
                $campo = true;
            }

            if ($mark_id) {
                $info['mark_id'] = $request['mark_id'];
                $campo = true;
            }

            if ($campo) {
                DB::table('products')->where('id', $request['id'])->update($info);
                $message = \Response::json(['code' => '200', 'message' => "Produto atualizado com sucesso!"]);
            } else {
                $message = \Response::json(['code' => '400', 'message' => "Nenhum campo de alteração foi preenchido!"]);
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do produto não informado!"]);
        }

        return $message;
    }

    public function updateCategory(Request $request)
    {
        $name = isset($request['name']);
        $id = isset($request['id']);
        $info = [];
        $campo = false;
        $message = "";

        if ($id) {
            if ($name) {
                $info['name'] = $request['name'];
                $campo = true;
            }

            if ($campo) {
                DB::table('categories')->where('id', $request['id'])->update($info);
                $message = \Response::json(['code' => '200', 'message' => "Categoria atualizado com sucesso!"]);
            } else {
                $message = \Response::json(['code' => '400', 'message' => "Nenhum campo de alteração foi preenchido!"]);
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID da categoria não informado!"]);
        }

        return $message;
    }

    public function updateMark(Request $request)
    {
        $name = isset($request['name']);
        $id = isset($request['id']);
        $info = [];
        $campo = false;
        $message = "";

        if ($id) {
            if ($name) {
                $info['name'] = $request['name'];
                $campo = true;
            }

            if ($campo) {
                DB::table('marks')->where('id', $request['id'])->update($info);
                $message = \Response::json(['code' => '200', 'message' => "Marca atualizado com sucesso!"]);
            } else {
                $message = \Response::json(['code' => '400', 'message' => "Nenhum campo de alteração foi preenchido!"]);
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do colaborador não informado!"]);
        }

        return $message;
    }

    public function deleteProduct(Request $request)
    {
        $id = isset($request['id']);
        if ($id) {
            DB::table('products')->where('id', $request['id'])->delete();
            $message = \Response::json(['code' => '200', 'message' => "Produto deletado com sucesso!"]);
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do produto não informado!"]);
        }

        return $message;
    }

    public function deleteCategory(Request $request)
    {
        $id = isset($request['id']);
        if ($id) {
            DB::table('categories')->where('id', $request['id'])->delete();
            $message = \Response::json(['code' => '200', 'message' => "Categoria deletado com sucesso!"]);
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID da categoria não informado!"]);
        }

        return $message;
    }

    public function deleteMark(Request $request)
    {
        $id = isset($request['id']);
        if ($id) {
            DB::table('marks')->where('id', $request['id'])->delete();
            $message = \Response::json(['code' => '200', 'message' => "Marca deletado com sucesso!"]);
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID da marca não informado!"]);
        }

        return $message;
    }
}

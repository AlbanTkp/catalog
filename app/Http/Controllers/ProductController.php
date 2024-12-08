<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Dompdf\Css\Stylesheet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class ProductController extends Controller
{

    public function printCatalog()
    {
        $data = [
            'products' => Product::with('category')->orderBy('name')->get()
        ];
        $html = view('pdf.catalog', $data)->render();
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream('catalog.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'page_title'=>'Articles',
            'categories'=>Category::all(),
            'products'=>Product::with('category')->orderBy('name')->get()
        ];
        return view('pages.products', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data =  session()->get('data-preview');
        if(!$data){
            return redirect()->back();
        }
        // dd($data);
        $data['categories'] = Category::all();

        return view('pages.products_preview', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if($request->step == 1){
                $prods = [];
                $data = [];
                if($request->hasFile('excel')){
                    $excel = (new ProductsImport)->toArray(request()->file('excel'));
                    foreach ($excel[0] as $key=>$value) {
                        if($key == 0) continue;
                        array_push($prods, [
                            'name'=>$value[1],
                            'price'=>$value[2],
                            'category'=>$value[3]
                        ]);
                    }
                    $data['type'] = "excel";
                }else{
                    $db_cats = Category::all();
                    $db_cats_ids = $db_cats->pluck('id')->toArray();
                    for ($i=0; $i < count($request['name']); $i++) {
                        $name = $request['name'][$i];
                        $price = $request['price'][$i];
                        $category = $db_cats[array_search($request['category'][$i], $db_cats_ids)];
                        array_push($prods, [
                            'name'=>strtoupper($name),
                            'price'=>$price,
                            'category'=>$category
                        ]);
                    }

                    $data["type"] = "form";
                }
                $data["prods"] = $prods;
                session()->put('data-preview',$data);
                return redirect()->route('products.create');
            }else{
                $photos = $request->file('photos');
                if (!is_array($photos)) {
                    // return response()->json(['error' => 'Aucun fichier n\'a été envoyé'], 400);
                }
                $db_cats = Category::all();
                if($request["type"] == "excel"){
                    $db_cats_names = $db_cats->pluck('name')->toArray();
                    array_walk($db_cats_names, function($value){
                        return strtoupper(removeAccents($value));
                    });
                    for ($i=0; $i < count($request['name']); $i++) {
                        $name = $request['name'][$i];
                        $price = $request['price'][$i];
                        $exist_cat = array_search(strtoupper(removeAccents($request['category'][$i])), $db_cats_names);
                        if(is_numeric($exist_cat)){
                            $category = $db_cats[$exist_cat];
                        }else{
                            $category = Category::create([
                                'name' => strtoupper($request['category'][$i])
                            ]);
                            $db_cats->push($category);
                            array_push($db_cats_names, strtoupper(removeAccents($category['name'])));
                        }
                        $photo = $this->uploadImage($photos[$i]);
                        $new_prod = new Product([
                            'photo'=>$photo,
                            'name'=>$name,
                            'price'=>$price,
                        ]);
                        $new_prod->category()->associate($category);
                        $new_prod->push();
                    }
                }else{
                    $db_cats_ids = $db_cats->pluck('id')->toArray();
                    for ($i=0; $i < count($request['name']); $i++) {
                        $name = $request['name'][$i];
                        $price = $request['price'][$i];
                        $category = $db_cats[array_search($request['category'][$i], $db_cats_ids)];
                        $photo = $this->uploadImage($photos[$i]);
                        $new_prod = new Product([
                            'photo'=>$photo,
                            'name'=>$name,
                            'price'=>$price,
                        ]);
                        $new_prod->category()->associate($category);
                        $new_prod->push();
                    }
                    session()->flash("alert",[
                        "type"=>"success",
                        "title"=>"Ajout d'article",
                        "message"=>"Articles ajoutés avec succès"
                    ]);
                }
                session()->remove('data-preview');
                return redirect()->route('products.index');
            }
        } catch (Exception $e) {
            session()->flash("alert",[
                "type"=>"error",
                "title"=>"Erreur",
                "message"=>$e->getMessage(),
            ]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        return sendResponse("success", [
            "product"=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product['name'] = $request['name'];
        $product['price'] = $request['price'];
        $product->category()->associate(Category::find($request['category']));
        $product->update();
        return sendResponse("Article modifié avec succès", [
            "product"=>$product
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return sendResponse("Article ".$product->name." supprimé avec succès");
    }


    public function uploadImage($image)
    {
        throw_unless($image->isValid() && str_starts_with($image->getClientMimeType(), 'image/'), "Image non valide");

        // Génération d'un nom unique pour l'image
        $filename = time() . '.' . $image->getClientOriginalExtension();

        // Déplacement du fichier dans le dossier de stockage
        $image->storeAs('public/images', $filename);

        // Retour de l'URL de l'image
        return 'storage/images/' . $filename;
    }




}

<?php

namespace App\Http\Controllers;


use App\Product;
use App\Category;
use App\Badge;
use App\BadgeProducts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Attributes;
use App\AttributesCategory;
use App\AttributesProduct;
use App\AttributesValues;
use App\SpecialOption;
use App\SpecialOptionForProducts;
use App\PaymentMethod;

use Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Input;


class ProductController extends Controller
{

    public function cart()
    {

        $intro = 'Moja korpa';
        $ulogovan = Auth::user();

        if ($ulogovan):
            $discount = $ulogovan->discount;
        else:
            $discount = 0;
        endif;

        $cart = array();

        if (Session::has('crt')):

            $cart = Session::get('crt');

        endif;


        // PAYMENT METHODS
        $paymenOptions = PaymentMethod::paymentMethods();


        //return $cart;

        return view('product.cart', compact('intro','ulogovan','cart','discount','paymenOptions'));
    }

    public function addToCart(Request $request)
    {

        // brisem celu sesiju za CART
        $crtOLD = Session::get('crt');

        // kreiram niz za KORPU
        $addToCart = array();

        // kreiram pregled proizvoda u korpi
        $cartVIEW = '';

        // postavljam brojac za niz
        $cartCNT = 0;

        // postavljam vrednost za DISCOUNT
        $ulogovan = Auth::user();

        if ($ulogovan):
            $addToCart['discount'] = $ulogovan->discount;
        else:
            $addToCart['discount'] = 0;
        endif;



        // postavljam 0 za TOTAL
        if ($crtOLD):
            $addToCart['total'] = $crtOLD['total'];
        else:
            $addToCart['total'] = 0;
        endif;

        $amountInProgres = 0;
        $daLiJeVecUKorpi = 0;


        //kolicina
        $prodQTTY = request('prodQTTY');

        // pronadji proizvod
        $findPRoduct = Product::productDATA(request('prodID'));
        $newProduct = (array) $findPRoduct;


        // Atributi za proizvod ------------------------------------------------------------ //

        // svi podaci o odabranim atributima
        $input_attr_DATA = array();

        // ako postoje dodeljeni atributi za proizvod
        if (request('attr_exist') == 1):

            $formDATA = request('formDATA');

            // odvajam sve podatke sa forme u poseban niz
            $input = array();
            foreach ($formDATA as $key => $form) {
                $input[$form['name']][] = $form['value'];
            }

            // odvajam samo odabrane atribute
            $input__attr_all = json_decode($input['attr_all'][0]);

            foreach ($input__attr_all as $key => $attributeID):
                if (array_key_exists('attr_'.$attributeID,$input)):

                    // uzimam podatke iz DB za atribut
                    $attributeDATA = Attributes::attributeDATA($attributeID);

                    $input_attr_DATA['attr_'.$attributeID]['id'] = $attributeDATA->attr_id; // ID atributa
                    $input_attr_DATA['attr_'.$attributeID]['name'] = 'attr_'.$attributeID;  // NAME atributa

                    foreach ($input['attr_'.$attributeID] as $key => $attrVAL) {

                        $attrVAL_expl = explode('|', $attrVAL);

                        $attrItem = AttributesValues::attributeVALUESbyID($attrVAL_expl[0]);

                        $input_attr_DATA['attr_'.$attributeID]['val'][$key]['id'] = $attrItem->attrval_id; // ID za value atributa
                        $input_attr_DATA['attr_'.$attributeID]['val'][$key]['label'] = $attrItem->attrval_label; // LABEL za value atributa
                        $input_attr_DATA['attr_'.$attributeID]['val'][$key]['value'] = $attrItem->attrval_value; // VALUE za value atributa

                    }

                    $input_attr_DATA['attr_'.$attributeID]['value'] = $input['attr_'.$attributeID]; // SVE poslate vrednosti za atribut
                    $input_attr_DATA['attr_'.$attributeID]['title'] = $attributeDATA->attr_title; // TITLE atributa
                    $input_attr_DATA['attr_'.$attributeID]['type'] = $attributeDATA->attr_type; // TYPE atributa
                endif;
            endforeach;

        endif;
        // Atributi za proizvod ------------------------------------------------------------ //

        // proveravam da li postoji SESIJA sa KORPOM
        if ($crtOLD):

            for ($o=0; $o < count($crtOLD['products']); $o++) {

                if ($crtOLD['products'][$o]['prod_id'] == request('prodID')):

                    $crtOLD['products'][$o]['quantity'] = $crtOLD['products'][$o]['quantity'] + $prodQTTY;

                    $crtOLD['products'][$o]['attr_data'] = $input_attr_DATA;

                    $daLiJeVecUKorpi = 1;

                endif;

            }

            $addToCart['products'] = $crtOLD['products'];

            // start za brojac
            $cartCNT = count($addToCart['products']);

        endif;

        if ($daLiJeVecUKorpi != 1):
            // dodajem nov proizvod u KORPU
            $addToCart['products'][$cartCNT] = $newProduct;
            $addToCart['products'][$cartCNT]['quantity'] = $prodQTTY;
            $addToCart['products'][$cartCNT]['attr_data'] = $input_attr_DATA;
        endif;


        //return json_encode($addToCart);

        // Ako je AJAX request za ADD TO CART (button click)
        if ($request->ajax()):

            for ($c=0; $c < count($addToCart['products']); $c++) {

                $cartVIEW .= '<div id="cartPRODrow" class="row fadeInRight wow fast">';

                $cartVIEW .= '  <div id="cartTXT" class="col-sm-8">';
                $cartVIEW .= '      <h3>'.$addToCart['products'][$c]['prod_title'].'</h3>';

                // ispis atributa
                if ($addToCart['products'][$c]['attr_data']):

                    $cartVIEW .= '      <div class="small">';

                    foreach ($addToCart['products'][$c]['attr_data'] as $atKey => $attr):
                        $cartVIEW .= '      <div class="attrONE">';

                        // ispis naziva za atribute
                        $cartVIEW .= '          <span class="font-weight-bold mr-1">'.$attr['title'].':</span>';

                        // ispis vrednosti za odabrane atribute
                        $i = 0;
                        $attrLABELs = '';
                        $cartVIEW .= '          <span>';
                        foreach ($attr['val'] as $valKey => $val) {
                            $attrLABELs .= $val['label'].', ';
                            $i++;
                        }
                        // sklanjam zarez sa iza poslednje ispisane vrednosti
                        if ($valKey == 0 || $valKey == ($i-1)):
                            $attrLABELs = substr($attrLABELs, 0, -2);
                        endif;
                        $cartVIEW .= $attrLABELs;
                        $cartVIEW .= '          </span>';

                        $cartVIEW .= '      </div>';
                    endforeach;

                    $cartVIEW .= '      </div>';

                endif;

                $cartVIEW .= '      <div class="priceWrap">';

                if ($addToCart['products'][$c]['prod_price_with_discount'] != null):
                    // ako proizvod ima definisanu cenu sa uracunatim discountom npr. 8999
                    $cartVIEW .= '  <span class="fullPrice">'.number_format($addToCart['products'][$c]['prod_price'],0,"",".").' '.setting('site.valuta').'</span>';

                    $fullAmount = $addToCart['products'][$c]['quantity'] * $addToCart['products'][$c]['prod_price_with_discount'];
                    $cartVIEW .= '  <div id="finalAmount"><span class="qty">'.$addToCart['products'][$c]['quantity'].'</span> x <span class="discountPrice">'.number_format($fullAmount,0,"",".").' '.setting('site.valuta').'</span></div>';

                elseif ($addToCart['products'][$c]['prod_discount'] != null):
                    // ako proizvod ima definisan popust na cenu kao procenat

                    $discountPrice = $addToCart['products'][$c]['prod_price']-(($addToCart['products'][$c]['prod_price']/100)*$addToCart['products'][$c]['prod_discount']);

                    $cartVIEW .= '  <span class="fullPrice">'.number_format($discountPrice,0,"",".").' '.setting('site.valuta').'</span>';

                    $fullAmount = $addToCart['products'][$c]['quantity'] * $discountPrice;
                    $cartVIEW .= '  <div id="finalAmount"><span class="qty">'.$addToCart['products'][$c]['quantity'].'</span> x <span class="discountPrice">'.number_format($fullAmount,0,"",".").' '.setting('site.valuta').'</span></div>';

                else:
                    // ako ide puna cena bez discounta
                    $fullAmount = $addToCart['products'][$c]['quantity'] * $addToCart['products'][$c]['prod_price'];
                    $cartVIEW .= '  <div id="finalAmount"><span class="qty">'.$addToCart['products'][$c]['quantity'].'</span> x <span class="singlePrice">'.number_format($fullAmount,0,"",".").' '.setting('site.valuta').'</span></div>';

                endif;
                $cartVIEW .= '      </div>';
                $cartVIEW .= '  </div>';

                $cartVIEW .= '  <div id="cartIMG" class="col-sm-4">';
                if ($addToCart['products'][$c]['prod_image'] != null):
                    $imgFILE = $addToCart['products'][$c]['prod_image'];
                else:
                    $imgFILE = 'no_image.jpg';
                endif;
                $cartVIEW .= '  <img src="/storage/products/'.$imgFILE.'" alt="'.$addToCart['products'][$c]['prod_title'].'">';
                $cartVIEW .= '  </div>';

                $cartVIEW .= '</div>';

                // Kreiram TOTAL ako postoji DISCOUNT
                $amountInProgres = $amountInProgres + $fullAmount;

            }

            // DISCOUNT
            $cartVIEW .= '<div id="cartDISCOUNT" class="row rounded-pill">';
            $cartVIEW .= '  <div class="col">';
            $cartVIEW .= '  <div id="cartDISCOUNTtxt">'.trans('shop.my_cart_discount').'</div>';
            $cartVIEW .= '  </div>';
            $cartVIEW .= '  <div class="col text-right">';
            $cartVIEW .= '  <span>'.$addToCart['discount'].'%</span>';
            $cartVIEW .= '  </div>';
            $cartVIEW .= '</div>';

            // racunam TOTAL ako postoji DISCOUNT
            if ($addToCart['discount'] > 0):
                $total = $amountInProgres - ($amountInProgres/100)*$addToCart['discount'];
            else:
                $total = $amountInProgres;
            endif;

            $addToCart['total'] = $total;

            // TOTAL
            $cartVIEW .= '<div id="cartTOTAL" class="row rounded-pill">';
            $cartVIEW .= '  <div class="col">';
            $cartVIEW .= '  <div id="cartTOTALtxt">'.trans('shop.my_cart_total').'</div>';
            $cartVIEW .= '  </div>';
            $cartVIEW .= '  <div class="col text-right" id="price_modal">';
            $cartVIEW .= '  <span id="priceH">'.number_format($total,0,"",".").'</span><span> '.setting('site.valuta').'</span>';
            $cartVIEW .= '  </div>';
            $cartVIEW .= '</div>';

            // kreiram SESSIJU sa KORPOM
            Session::forget('crt');
            Session::put('crt', $addToCart);

           // return $cartVIEW;
            return response()->json(['cart'=>$cartVIEW,'header_price'=>$total]);

        else:


        endif;


        //return  redirect('/moja-korpa');
    }

    public function removeFromCart(Request $request)
    {

        // podaci iz sesije
        $crt = Session::get('crt');

        // podaci sa POSTa
        $unsetID = request('prodID');

        // default values
        $addToCart['discount'] = $crt['discount'];
        $addToCart['total'] = 0;
        $cartDATA['count'] = 0;
        $cartDATA['price'] = 0;
        $fullAmount = 0;

        // uklanjam odabrani proizvod iz sesije
        for ($a=0; $a<count($crt['products']); $a++) {
            if ($crt['products'][$a]['prod_id'] == $unsetID):
                unset($crt['products'][$a]);
            endif;
        }

        // reindex product
        $reorderCRT = array_values($crt['products']);

        //return $reorderCRT;

        // spremam proizvode iz sesije
        $addToCart['products'] = $reorderCRT;


        for ($a=0; $a<count($reorderCRT); $a++) {

            // Kreiram TOTAL za CART
            if ($reorderCRT[$a]['prod_price_with_discount'] != null):

                $fullAmount = $reorderCRT[$a]['quantity'] * $reorderCRT[$a]['prod_price_with_discount'];

            elseif ($crt['products'][$a]['prod_discount'] != null):

                $discountPrice = $crt['products'][$a]['prod_price'] - (($crt['products'][$a]['prod_price'] / 100) * $crt['products'][$a]['prod_discount']);
                $fullAmount = $crt['products'][$a]['quantity'] * $discountPrice;

            else:

                $fullAmount = $reorderCRT[$a]['quantity'] * $reorderCRT[$a]['prod_price'];

            endif;

            // kreiram COUNT za cart
            $cartDATA['count'] = $cartDATA['count'] + $reorderCRT[$a]['quantity'];
            $cartDATA['price'] = $fullAmount;

        }

        // Kreiram TOTAL za KORPU
        $addToCart['total'] = $addToCart['total'] + $fullAmount;

        Session::forget('crt');
        Session::put('crt', $addToCart);

        // Ako je AJAX request za ADD TO CART (button click)
        if ($request->ajax()):

            return 'ok';

        else:

            //return  redirect('/moja-korpa');

        endif;
    }

    public function updateQTY(Request $request)
    {

        // podaci iz sesije
        $crt = Session::get('crt');

        // podaci sa POSTa
        $prodID = request('prodID');
        $newQTY = request('newQTY');
        $mathOPR = request('mathOPR');

        // default values
        $addToCart['discount'] = $crt['discount'];

        if ($crt):
            $addToCart['total'] = $crt['total'];
        else:
            $addToCart['total'] = 0;
        endif;

        $cartDATA['count'] = 0;
        $fullAmount = 0;

        // uklanjam odabrani proizvod iz sesije
        for ($a=0; $a<count($crt['products']); $a++) {

            if ($crt['products'][$a]['prod_id'] == $prodID):

                // Kreiram TOTAL za CART
                if ($crt['products'][$a]['prod_price_with_discount'] != null):

                    $fullAmount = $crt['products'][$a]['quantity'] * $crt['products'][$a]['prod_price_with_discount'];
                    $singlePrice = $crt['products'][$a]['prod_price_with_discount'];

                elseif ($crt['products'][$a]['prod_discount'] != null):

                    $discountPrice = $crt['products'][$a]['prod_price'] - (($crt['products'][$a]['prod_price'] / 100) * $crt['products'][$a]['prod_discount']);
                    $fullAmount = $crt['products'][$a]['quantity'] * $discountPrice;
                    $singlePrice = $discountPrice;

                else:

                    $fullAmount = $crt['products'][$a]['quantity'] * $crt['products'][$a]['prod_price'];
                    $singlePrice = $crt['products'][$a]['prod_price'];

                endif;

                $crt['products'][$a]['quantity'] = $newQTY;

            endif;

            // kreiram COUNT za cart
            $cartDATA['count'] = $cartDATA['count'] + $crt['products'][$a]['quantity'];
            $cartDATA['price'] = $fullAmount;
        }

        $addToCart['products'] = $crt['products'];

        // Kreiram TOTAL za KORPU
        if ($mathOPR == 'plus'):
            $addToCart['total'] = $addToCart['total'] + $singlePrice;
        else:
            $addToCart['total'] = $addToCart['total'] - $singlePrice;
        endif;

        Session::forget('crt');
        Session::put('crt', $addToCart);

        // Ako je AJAX request za ADD TO CART (button click)
        if ($request->ajax()):

            return 'ok';

        else:

            //return  redirect('/moja-korpa');

        endif;
    }


	public function storeProcessingInsert(Request $request)
    {

    	$product = new Product;

    	$sada = Carbon::now();
        $ulogovan = Auth::user();


    	$product->product_id = request('product_id');
    	$product->sku = request('sku');
        $product->product_price = request('product_price');
        $product->title = request('title');
        $product->slug = request('slug');
        $product->category_id = request('category_id');
        $product->manufacturer_id = request('manufacturer_id');
        $product->author_id = $ulogovan->id;
    	$product->excerpt = request('excerpt');
    	$product->body = request('body');
        $product->specification = request('specification');
        $product->video = request('video');
        $product->meta_description = request('meta_description');
        $product->meta_keywords = request('meta_keywords');

        $productDisplayOptions = request('specal_options');

        $productBadge = request('product_badge');

    	$product->price = request('price');
        $product->product_price_with_discount = request('product_price_with_discount');

        $product->product_discount = request('product_discount');

        if (request('status') == 'on'):
            $product->status = 1;
        else:
            $product->status = 0;
        endif;

        if (request('on_stock') == 'on'):
            $product->on_stock= 1;
        else:
            $product->on_stock = 0;
        endif;

        if (request('featured') == 'on'):
            $product->featured = 1;
        else:
            $product->featured = 0;
        endif;

        $product->update_on_import = 1;

    	$product->created_at = $sada;
    	$product->updated_at = $sada;

        // postavlja se SLIKA ako je odabrana
        if (request('image') != null ) {
            $image = $request->file('image');

            $new_name = $product->category_id.'-'.date_format(Carbon::now(),"dmYHis").'-'.$image->getClientOriginalName();

            $img = Image::make(Input::file('image'));

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $path = public_path('storage/products/'.$new_name);
            //$path = public_path('uploads/products/'.$new_name);
            $img->save($path);

            $product->image = $new_name;
        } else {
            $product->image = '';
        }

        $insert_wID = DB::table('products')->insertGetId([
            'sku' => $product->sku,
            'title' => $product->title,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'author_id' => $product->author_id,
            'manufacturer_id' => $product->manufacturer_id,
            'excerpt' => $product->excerpt,
            'body' => $product->body,
            'specification' => $product->specification,
            'image' => $product->image,
            'video' => $product->video,
            'meta_description' => $product->meta_description,
            'meta_keywords' => $product->meta_keywords,
            'status' => $product->status,
            'on_stock' => $product->on_stock,
            'update_on_import' => $product->update_on_import,
            'featured' => $product->featured,
            'product_price' => $product->product_price,
            'product_discount' => $product->product_discount,
            'product_price_with_discount' => $product->product_price_with_discount,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ]);

        // ID unetog PROIZVODA
        $product_id = $insert_wID;

        // INSERT TRIBUTA za PROIZVOD ------------------------------------------------------------------------ //
        $attrALL = array();
        if (request('attr_all') != ''):
            $attrALL = json_decode(request('attr_all'));
        endif;

        $listOfSelectedAttr = array();
        $attrCNT = 0;

        foreach ($attrALL as $key => $attrID) {

            //proveravam da li psotoji request za ID atributa
            if (null !== request('attr_'.$attrID)):

                //proveravam da li je po postata vrednost NIZ (CHECKBOX, MULTISELECT, COLOR)
                if (is_array(request('attr_'.$attrID))):

                    // ako je poslat NIZ
                    $poslateVrednostiZaAttribut = request('attr_'.$attrID);

                    foreach ($poslateVrednostiZaAttribut as $key => $vrednostiZaAtribut) {

                        $listOfSelectedAttr[$attrCNT]['attribute_id'] = $attrID; // ATRIBUT ID

                        $attrVAL = explode('|', $vrednostiZaAtribut);

                        $listOfSelectedAttr[$attrCNT]['attribute_value_id'] = $attrVAL[0]; // ATTRIBUTE VALUE ID

                        $listOfSelectedAttr[$attrCNT]['product_id'] = $product_id; // PRODUCT ID
                        $listOfSelectedAttr[$attrCNT]['created_at'] = $sada;
                        $listOfSelectedAttr[$attrCNT]['updated_at'] = $sada;

                        $attrCNT++;

                    }

                else:

                    // ako je posla jedna vrednost
                    $attrVAL = explode('|', request('attr_'.$attrID));

                    $listOfSelectedAttr[$attrCNT]['attribute_id'] = $attrID; // ATRIBUT ID

                    $listOfSelectedAttr[$attrCNT]['attribute_value_id'] = $attrVAL[0]; // ATTRIBUTE VALUE ID

                    $listOfSelectedAttr[$attrCNT]['product_id'] = $product_id; // PRODUCT ID
                    $listOfSelectedAttr[$attrCNT]['created_at'] = $sada;
                    $listOfSelectedAttr[$attrCNT]['updated_at'] = $sada;

                    $attrCNT++;

                endif;

            endif;

        }

        $insertATTR = AttributesProduct::insert($listOfSelectedAttr);
        // INSERT TRIBUTA za PROIZVOD ------------------------------------------------------------------------ //


        // SPECIAL DISPLAY OPTIONS ---------------------------------------------------------------------- //
        $displayOptions = array();

        if ($productDisplayOptions):
            for ($d=0; $d < count($productDisplayOptions); $d++) {
                $displayOptions[$d]['special_options_id'] = $productDisplayOptions[$d];
                $displayOptions[$d]['product_id'] = $product_id;
            }
        endif;

        $DaLiImaDefinisaneOpcije = SpecialOptionForProducts::where('product_id',$product_id)->first();

        if ($DaLiImaDefinisaneOpcije):

            $delete_SepacialDisplayOptions = SpecialOptionForProducts::where('product_id',$product_id)->delete();

        endif;

        $insert_SpecialOptions = SpecialOptionForProducts::where('product_id',$product_id)->insert($displayOptions);

        // SPECIAL DISPLAY OPTIONS ---------------------------------------------------------------------- //

        // PRODUCT BADGES ------------------------------------------------------------------------------- //

        if($productBadge != ''):

            $insertBadge = BadgeProducts::insert([
                'product_id' => $product_id,
                'badge_id' => $productBadge
            ]);

        endif;

        // PRODUCT BADGES ------------------------------------------------------------------------------- //


    	return  redirect('/SDFSDf345345--DFgghjtyut-6/products')
                ->with([
                    'message'    => __('voyager::generic.successfully_added_new').": {$product->title}",
                    'alert-type' => 'success',
                ]);
    }

	public function storeProcessingEdit(Request $request)
    {

        $product = new Product;

        $sada = Carbon::now();
        $ulogovan = Auth::user();

        $productDATA = Product::where('id',request('product_id'))->first();

        $product->product_id = request('product_id');
        $product->title = request('title');
        $product->excerpt = request('excerpt');
        $product->body = request('body');
        $product->specification = request('specification');
        $product->sku = request('sku');
        $product->product_price = request('product_price');
        $product->product_discount = request('product_discount');
        $product->product_price_with_discount = request('product_price_with_discount');
        $product->price = request('price');
        $product->slug = request('slug');
        $product->category_id = request('category_id');
        $product->manufacturer_id = request('manufacturer_id');
        $product->video = request('video');

        $productDisplayOptions = request('specal_options');

        $productBadge = request('product_badge');


    	if (request('status') == 'on'):
    		$product->status = 1;
    	else:
    		$product->status = 0;
    	endif;

        if (request('on_stock') == 'on'):
            $product->on_stock = 1;
        else:
            $product->on_stock = 0;
        endif;

    	if (request('featured') == 'on'):
    		$product->featured = 1;
    	else:
    		$product->featured = 0;
    	endif;

        if (request('update_on_import') == 'on'):
            $product->update_on_import = 1;
        else:
            $product->update_on_import = 0;
        endif;


    	if (request('image') == null):
    		$product->image = $productDATA->image;
    	else:
    		$product->image = request('image');
    	endif;

    	$product->meta_description = request('meta_description');
    	$product->meta_keywords = request('meta_keywords');

    	$product->updated_at = $sada;

        // postavlja se SLIKA ako je odabrana
        if (request('image') != null ) {
            $image = $request->file('image');

            $new_name = $product->category_id.'-'.date_format(Carbon::now(),"dmYHis").'-'.$image->getClientOriginalName();

            $img = Image::make(Input::file('image'));

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $path = public_path('storage/products/'.$new_name);

            $img->save($path);

            $product->image = $new_name;
        } else {
            $product->image = $productDATA->image;
        }

        $update = DB::table('products')->where('id',$product->product_id)->update([
            'sku' => $product->sku,
            'title' => $product->title,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'author_id' => $product->author_id,
            'manufacturer_id' => $product->manufacturer_id,
            'excerpt' => $product->excerpt,
            'body' => $product->body,
            'specification' => $product->specification,
            'image' => $product->image,
            'video' => $product->video,
            'meta_description' => $product->meta_description,
            'meta_keywords' => $product->meta_keywords,
            'status' => $product->status,
            'on_stock' => $product->on_stock,
            'update_on_import' => $product->update_on_import,
            'product_price' => $product->product_price,
            'product_discount' => $product->product_discount,
            'product_price_with_discount' => $product->product_price_with_discount,
            'featured' => $product->featured,
            'updated_at' => $product->updated_at,
        ]);

        // INSERT TRIBUTA za PROIZVOD ------------------------------------------------------------------------ //

        // proveravam da li vec postoje dodeljene vrednosti za atribute za odabrani proizvod
        $chkIf_SelectedAttributeValues = AttributesProduct::where('product_id',$product->product_id)->first();

        // ako postoje, brisem sve i upisujem nove
        if ($chkIf_SelectedAttributeValues):
            $delete_SelectedAttributeValues = AttributesProduct::where('product_id',$product->product_id)->delete();
        endif;


        // ako se stara kategorija razlikuje od nove // ako je doslo do PROEMENE kategorije
        if ($productDATA->category_id == $product->category_id):

            // proveravam da li vec postoje dodeljene vrednosti za atribute za odabrani proizvod
            $chkIf_SelectedAttributeValues = AttributesProduct::where('product_id',$product->product_id)->first();

            // ako postoje, brisem sve i upisujem nove
            if ($chkIf_SelectedAttributeValues):
                $delete_SelectedAttributeValues = AttributesProduct::where('product_id',$product->product_id)->delete();
            endif;

            // upisujem nove vrednosti za atribute
            $attrALL = json_decode(request('attr_all'));

            $listOfSelectedAttr = array();
            $attrCNT = 0;

            foreach ($attrALL as $key => $attrID) {

                //proveravam da li psotoji request za ID atributa
                if (null !== request('attr_'.$attrID)):

                    //proveravam da li je po postata vrednost NIZ (CHECKBOX, MULTISELECT, COLOR)
                    if (is_array(request('attr_'.$attrID))):

                        // ako je poslat NIZ
                        $poslateVrednostiZaAttribut = request('attr_'.$attrID);

                        foreach ($poslateVrednostiZaAttribut as $key => $vrednostiZaAtribut) {

                            $listOfSelectedAttr[$attrCNT]['attribute_id'] = $attrID; // ATRIBUT ID

                            $attrVAL = explode('|', $vrednostiZaAtribut);

                            $listOfSelectedAttr[$attrCNT]['attribute_value_id'] = $attrVAL[0]; // ATTRIBUTE VALUE ID

                            $listOfSelectedAttr[$attrCNT]['product_id'] = $product->product_id; // PRODUCT ID
                            $listOfSelectedAttr[$attrCNT]['created_at'] = $sada;
                            $listOfSelectedAttr[$attrCNT]['updated_at'] = $sada;

                            $attrCNT++;

                        }

                    else:

                        // ako je posla jedna vrednost
                        $attrVAL = explode('|', request('attr_'.$attrID));

                        $listOfSelectedAttr[$attrCNT]['attribute_id'] = $attrID; // ATRIBUT ID

                        $listOfSelectedAttr[$attrCNT]['attribute_value_id'] = $attrVAL[0]; // ATTRIBUTE VALUE ID

                        $listOfSelectedAttr[$attrCNT]['product_id'] = $product->product_id; // PRODUCT ID
                        $listOfSelectedAttr[$attrCNT]['created_at'] = $sada;
                        $listOfSelectedAttr[$attrCNT]['updated_at'] = $sada;

                        $attrCNT++;

                    endif;

                endif;

            }

            $insertATTR = AttributesProduct::insert($listOfSelectedAttr);

        endif;
        // INSERT TRIBUTA za PROIZVOD ------------------------------------------------------------------------ //


        // SPECIAL DISPLAY OPTIONS ---------------------------------------------------------------------- //
        $displayOptions = array();

        if ($productDisplayOptions):
            for ($d=0; $d < count($productDisplayOptions); $d++) {
                $displayOptions[$d]['special_options_id'] = $productDisplayOptions[$d];
                $displayOptions[$d]['product_id'] = $product->product_id;
            }
        endif;

        $DaLiImaDefinisaneOpcije = SpecialOptionForProducts::where('product_id',$product->product_id)->first();

        if ($DaLiImaDefinisaneOpcije):

            $delete_SepacialDisplayOptions = SpecialOptionForProducts::where('product_id',$product->product_id)->delete();

        endif;

        $insert_SpecialOptions = SpecialOptionForProducts::where('product_id',$product->product_id)->insert($displayOptions);

        // SPECIAL DISPLAY OPTIONS ---------------------------------------------------------------------- //

        // PRODUCT BADGES ------------------------------------------------------------------------------- //

        if($productBadge != ''):

                // ako je poslata vrednost za BADGE ide UPDATE ili INSERT
                $badge_UPDATEorCREATE = BadgeProducts::updateOrCreate(

                    ['product_id' => $product->product_id],
                    [
                        'badge_id' => $productBadge
                    ]

                );
        else:
            // ako je poslata vrednost za BADGE prvo proveravam da li postoji dodeljen badge
            // ako postoji ide DELETE
            $chkIfBadgeExist = BadgeProducts::where('product_id',$product->product_id)->first();

            if($chkIfBadgeExist):
                $deleteBadge = BadgeProducts::where('product_id',$product->product_id)->delete();
            endif;

        endif;

        // PRODUCT BADGES ------------------------------------------------------------------------------- //


        return  redirect('/SDFSDf345345--DFgghjtyut-6/products')
                ->with([
                    'message'    => __('voyager::generic.successfully_updated').": {$product->title}",
                    'alert-type' => 'success',
                ]);
    }


    public function findeAttributes(Request $request)
    {
        $categoryID = request('CAT');

        $dostupniAtributi = AttributesCategory::attributesDATA_for_Category($categoryID);

        $htmlRSP = '';
        $listOfAttributes = array();

        foreach ($dostupniAtributi as $key => $atribut) {

            $htmlRSP .= '<div class="form-group">';
            $htmlRSP .= '<label class="control-label mar_b_0 text-bold">'.$atribut['attr_name'].'</label>';
            $htmlRSP .= '<div class="small mar_b_5">'.$atribut['attr_description'].'</div>';

            // kreiram spisak IDjeva atributa. Koristiti kasnije kod inserta ili edita
            array_push($listOfAttributes, $atribut['attr_id']);


            if ($atribut['attr_type_id'] == 1) {
                //TXT nije ufunkciji

            } else if ($atribut['attr_type_id'] == 2) {
                // SELECT

                $htmlRSP .= '<select class="form-control select2" id="sel2" name="attr_'.$atribut['attr_id'].'">';
                $htmlRSP .= '<option value="">'.trans('shop_admin.title_choose').'</option>';

                foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions) {
                    $htmlRSP .= '<option value="'.$ATTRoptions['id'].'|'.$ATTRoptions['value'].'">'.$ATTRoptions['label'].'  '.$atribut['attr_unit'].'</option>';
                }

                $htmlRSP .= '</select>';

            } else if ($atribut['attr_type_id'] == 3) {
                // MULTISELECT

                $htmlRSP .= '<select class="form-control select2" id="sel2" name="attr_'.$atribut['attr_id'].'[]" multiple="">';
                $htmlRSP .= '<option value="">'.trans('shop_admin.title_choose').'</option>';

                foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions) {
                    $htmlRSP .= '<option value="'.$ATTRoptions['id'].'|'.$ATTRoptions['value'].'">'.$ATTRoptions['label'].' '.$atribut['attr_unit'].'</option>';
                }

                $htmlRSP .= '</select>';

            } else if ($atribut['attr_type_id'] == 4) {
                // CHECKBOX

                foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions) {
                    $htmlRSP .= '<input type="checkbox" name="attr_'.$atribut['attr_id'].'[]" value="'.$ATTRoptions['id'].'|'.$ATTRoptions['value'].'"> '.$ATTRoptions['label'].' '.$atribut['attr_unit'].'<br>';
                }

            } else if ($atribut['attr_type_id'] == 5) {
                // RADIO BUTTON

                foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions) {
                    $htmlRSP .= '<input type="radio" name="attr_'.$atribut['attr_id'].'" value="'.$ATTRoptions['id'].'|'.$ATTRoptions['value'].'"> '.$ATTRoptions['label'].' '.$atribut['attr_unit'].'<br>';
                }

            } else if ($atribut['attr_type_id'] == 7) {
                // COLOR

                foreach ($atribut['attr_values'] as $ATTRkey => $ATTRoptions) {
                    $htmlRSP .= '<input type="checkbox" name="attr_'.$atribut['attr_id'].'[]" value="'.$ATTRoptions['id'].'|'.$ATTRoptions['value'].'"> <div class="btn mar_l_10 mar_r_10" style="background-color: '.$ATTRoptions['value'].'"></div> '.$ATTRoptions['label'].' '.$atribut['attr_unit'].'<br>';
                }

            } else {
                // NESTO DRUGO

            }


            $htmlRSP .= '</div>';
            $htmlRSP .= '<hr>';
        }

            $htmlRSP .= '<input type="hidden" name="attr_all" value="'.json_encode($listOfAttributes).'">';

        return $htmlRSP;
    }

}

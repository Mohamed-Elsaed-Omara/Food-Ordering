<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FrontendController extends Controller
{
    function index() : View
    {
        $sectionTitles = $this->getSectionTitles();

        $sliders = Slider::where('status',1)->get();
        $whyChooseUs = WhyChooseUs::where('status',1)->get();

        $categories = Category::with(['products' => function($query){
            $query->where('status',1)
            ->where('show_at_home',1)
            ->orderBy('id','desc')
            ->take(8);
        }])
        ->where('status',1)
        ->where('show_at_home',1)
        ->get();
        return view('frontend.home.index',compact(
            'sliders',
            'sectionTitles',
            'whyChooseUs',
            'categories'
        ));
    }

    function getSectionTitles() : Collection{

        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        return SectionTitle::whereIn('key',$keys)->pluck('value','key');
    }

    public function showProduct(string $slug) : View
    {
        $product = Product::with(['images','sizes','options'])->where(['slug' => $slug,'status' => 1])->firstOrFail();
        $relatedProducts = Product::where(['category_id' => $product->category_id,'status' => 1])
                            ->where('id','!=',$product->id)
                            ->take(8)
                            ->latest()
                            ->get();
        return view('frontend.pages.product-view',compact('product','relatedProducts'));
    }

    public function loadProductModel($productId)
    {
        $product = Product::with(['sizes','options'])->findOrFail($productId);
        return view('frontend.layouts.ajax-request.cart-popup',compact('product'))->render();
    }
}

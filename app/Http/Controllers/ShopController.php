<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function getAllProductsForShop(Request $requset){



        $productForPage = $requset->forPage;



        $requestFilter = request()->all();


    }

    public function getColors(){



    }


    public function getSizes(){



    }


}

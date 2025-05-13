<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Company; 
use Illuminate\Support\Facades\Auth;
use App\Models\Product; 
use App\Models\Wholesaler;

class MainController extends Controller {
    public function company($company) {
        $company = Company::where('name', str_replace('-', ' ', $company))->first(); 

        if(!$company) {
            return redirect('/teacher/companies'); 
        }

        return view('web.sections.authorized.teacher.single-company', [
            'company' => $company
        ]);
    }

    public function marketCompany(Request $request, $company) {
        $product = $request->query('product'); 

        $requestCompany = Company::where('name', str_replace('-', ' ', $company))->first();

        $isCompanyProduct = Product::where('company_id', $requestCompany->id)->where('label',  str_replace('-', ' ', $product))->exists();

        return view('web.sections.authorized.market.company', [
            'company' => $company,
            'product' => $isCompanyProduct ? $product : false
        ]);
    }
    
    public function wholesalerProducts($id) {
        $wholesaler = Wholesaler::findOrFail($id);
        
        // Check if user can access this wholesaler (based on center)
        if ($wholesaler->center_id != auth()->user()->center_id) {
            return redirect('/teacher/wholesalers')->with('error', 'No tienes acceso a este mayorista');
        }
        
        return view('web.sections.authorized.teacher.wholesaler-products', [
            'wholesaler' => $wholesaler
        ]);
    }
}

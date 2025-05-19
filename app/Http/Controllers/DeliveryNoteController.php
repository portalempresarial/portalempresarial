<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryNote;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliveryNoteController extends Controller
{    /**
     * Display a listing of delivery notes for the current company
     */
    public function index($company = null)
    {
        // El middleware isCompanyEmployee ya ha establecido current_company en Auth::user()
        $currentCompany = Auth::user()->current_company;
        $deliveryNotes = DeliveryNote::where('company_id', $currentCompany)
            ->with(['wholesaler', 'company', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('web.sections.authorized.student.delivery-notes', compact('deliveryNotes'));
    }
      /**
     * Display a specific delivery note
     */
    public function show($company = null, $id)
    {
        // El middleware isCompanyEmployee ya ha establecido current_company en Auth::user()
        $currentCompany = Auth::user()->current_company;
        $deliveryNote = DeliveryNote::where('id', $id)
            ->where('company_id', $currentCompany)
            ->with(['order.products.wholesalerProduct', 'wholesaler', 'company'])
            ->firstOrFail();
            
        return view('web.sections.authorized.student.delivery-note-detail', compact('deliveryNote'));
    }
      /**
     * Download the PDF for a delivery note
     */
    public function download($company = null, $id)
    {
        // El middleware isCompanyEmployee ya ha establecido current_company en Auth::user()
        $currentCompany = Auth::user()->current_company;
        $deliveryNote = DeliveryNote::where('id', $id)
            ->where('company_id', $currentCompany)
            ->firstOrFail();
            
        if (!$deliveryNote->pdf_path || !Storage::exists('public/' . $deliveryNote->pdf_path)) {
            return back()->with('error', 'El archivo PDF del albarán no está disponible');
        }
        
        return response()->download(storage_path('app/public/' . $deliveryNote->pdf_path), 
            'albaran_' . $deliveryNote->number . '.pdf');
    }
}

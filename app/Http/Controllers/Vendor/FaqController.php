<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
   public function index()
    {
        // Group FAQs by category
        $faqs = Faq::orderBy('category')->get()->groupBy('category');

        return view('vendors.faq.faq', compact('faqs'));
    }

    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        return view('vendors.faq.faq-details', compact('faq'));
    }

    // Optional: For adding new FAQ (admin only)
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        Faq::create($request->only(['category', 'question', 'answer']));

        return back()->with('success', 'FAQ added successfully.');
    }
}

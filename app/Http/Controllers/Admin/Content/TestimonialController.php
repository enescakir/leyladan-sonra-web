<?php

namespace App\Http\Controllers\Admin\Content;

use App\Filters\TestimonialFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(TestimonialFilter $filters)
    {
        $testimonials = Testimonial::latest()->filter($filters)->safePaginate();
        $sources = Testimonial::toSourceSelect('Hepsi');

        return view('admin.testimonial.index', compact('testimonials', 'sources'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        $this->validateTestimonial($request);
        $testimonial = Testimonial::create($request->only(['name', 'text', 'via', 'priority']));

        session_success(__('messages.testimonial.create', ['name' => $testimonial->name]));

        return redirect()->route('admin.testimonial.index');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->validateTestimonial($request);
        $testimonial->update($request->only(['name', 'text', 'via', 'priority']));

        session_success(__('messages.testimonial.update', ['name' => $testimonial->name]));

        return redirect()->route('admin.testimonial.index');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return api_success($testimonial);
    }

    public function approve(Request $request, Testimonial $testimonial)
    {
        $testimonial->approve($request->approval);

        return api_success([
            'approval'    => (int)$testimonial->isApproved(),
            'testimonial' => $testimonial
        ]);
    }

    private function validateTestimonial(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'text'     => 'required',
            'via'      => 'required',
            'priority' => 'required|numeric'
        ]);
    }

}

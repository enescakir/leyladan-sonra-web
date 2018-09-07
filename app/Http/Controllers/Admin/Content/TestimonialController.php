<?php

namespace App\Http\Controllers\Admin\Content;

use App\Filters\TestimonialFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends AdminController
{

    public function index(TestimonialFilter $filters)
    {
        $testimonials = Testimonial::orderBy('id', 'DESC');
        $testimonials->filter($filters);
        $testimonials = $testimonials->paginate();
        $sources = Testimonial::toSourceSelect('Hepsi');
        return view('admin.testimonial.index', compact('testimonials', 'sources'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, Testimonial::$rules);
        $testimonial = Testimonial::create($request->all());
        session_success(__('messages.testimonial.create', ['name' =>  $testimonial->name]));
        return redirect()->route('admin.testimonial.index');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->validate($request, Testimonial::$rules);
        $testimonial->update($request->all());
        session_success(__('messages.testimonial.update', ['name' =>  $testimonial->name]));
        return redirect()->route('admin.testimonial.index');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return $testimonial;
    }

    public function approve(Request $request, Testimonial $testimonial)
    {
        $testimonial->approve($request->approve);
        return $testimonial;
    }
}

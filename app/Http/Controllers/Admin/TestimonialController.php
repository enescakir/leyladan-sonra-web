<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $testimonials = Testimonial::orderBy('id', 'DESC');
        if ($request->filled('search')) {
            $testimonials = $testimonials->search($request->search);
        }
        if ($request->filled('download')) {
            Testimonial::download($testimonials);
        }
        $testimonials = $testimonials->paginate(25);
        return view('admin.testimonial.index', compact(['testimonials']));
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
        return view('admin.testimonial.edit', compact(['testimonial']));
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

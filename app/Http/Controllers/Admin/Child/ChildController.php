<?php

namespace App\Http\Controllers\Admin\Child;

use App\Enums\FeedType;
use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Post;
use App\Models\WishCategory;
use App\Services\ProcessService;
use App\Services\FeedService;
use Illuminate\Http\Request;
use App\Enums\GiftStatus;
use App\Enums\PostType;
use App\Http\Requests\CreateChildRequest;
use App\Models\Child;
use App\Models\Faculty;
use App\Models\Diagnosis;
use Carbon\Carbon;
use App\Filters\ChildFilter;

class ChildController extends Controller
{
    protected $processService;
    protected $feedService;

    public function __construct(ProcessService $processService, FeedService $feedService)
    {
        $this->middleware('auth');
        $this->processService = $processService;
        $this->feedService = $feedService;
    }

    public function index(ChildFilter $filters)
    {
        $this->authorize('list', Child::class);

        $children = Child::filter($filters)->with('faculty', 'media')->latest()->safePaginate();

        return view('admin.child.index', compact('children'));
    }

    public function create()
    {
        $this->authorize('create', Child::class);

        $faculties = Faculty::toSelect('Fakülte seçiniz', 'full_name', 'id', 'name');
        $users = auth()->user()->faculty->users()->toSelect(null, 'full_name', 'id', 'first_name');
        $diagnosises = Diagnosis::toSelect('Tanı seçiniz', 'name', 'name');
        $departments = Department::toSelect('Departman seçiniz', 'name', 'name');
        $categories = WishCategory::toSelect('Dilek kategorisi seçiniz');

        return view('admin.child.create', compact('faculties', 'users', 'diagnosises', 'departments', 'categories'));
    }

    public function store(CreateChildRequest $request)
    {
        $this->authorize('create', Child::class);

        $this->checkSimilarChildren($request->first_name, $request->last_name, $request->similarity_accept);

        if (!(count($request->mediaId) == count($request->mediaName)
            && count($request->mediaId) == count($request->mediaRatio)
            && count($request->mediaId) == count($request->mediaFeature))) {
            session_error("Çocuğun fotoğraflarında bir problem var. Lütfen tekrar yükleyiniz");
            return redirect()->back()->withInput();
        }

        $data = $request->only([
            'department', 'first_name', 'last_name', 'diagnosis', 'diagnosis_desc', 'taken_treatment', 'child_state',
            'child_state_desc', 'gender', 'meeting_day', 'birthday', 'wish', 'g_first_name', 'g_last_name', 'g_mobile',
            'g_email', 'province', 'city', 'address', 'extra_info', 'faculty_id', 'is_name_public',
            'is_diagnosis_public', 'wish_category_id'
        ]);
        $data['is_name_public'] = $request->has('is_name_public');
        $data['is_diagnosis_public'] = $request->has('is_diagnosis_public');
        $data['gift_state'] = GiftStatus::Waiting;
        $data['until'] = Carbon::createFromFormat('d.m.Y', $request->meeting_day)->addYear();

        $child = Child::create($data);
        $child->updateSlug();
        $child->users()->sync($request->users);

        if ($request->hasFile('verification_doc')) {
            $child->addVerificationDoc($request->file('verification_doc'));
        }

        $post = Post::create([
            'child_id' => $child->id,
            'text'     => $request->meeting_text,
            'type'     => PostType::Meeting
        ]);
        $child->meetingPost()->associate($post);
        $child->save();

        $child->meetingPost->addTempMedia($request->mediaId, $request->mediaName, $request->mediaRatio,
            $request->mediaFeature);

        if (!$child->featuredMedia) {
            $child->featuredMedia()->associate($post->getFirstMedia());
            $child->save();
        }

        $this->processService->create($child, ProcessType::Created);
        $this->feedService->create($child->faculty, FeedType::ChildCreated, ['child' => $child->full_name]);

        session_success("<strong>{$child->full_name}</strong> başarıyla sisteme eklendi.");
        return redirect()->route('admin.child.show', $child->id);
    }

    public function show(Child $child)
    {
        $this->authorize('view', $child);

        $child->load('processes', 'meetingPost.media', 'deliveryPost.media');
        return view('admin.child.show', compact('child'));
    }

    public function edit(Child $child)
    {
        $this->authorize('update', $child);

        $faculties = Faculty::toSelect('Fakülte seçiniz', 'full_name', 'id', 'name');
        $users = $child->faculty->users()->toSelect(null, 'full_name', 'id', 'first_name');
        $diagnosises = Diagnosis::toSelect('Tanı seçiniz', 'name', 'name');
        $departments = Department::toSelect('Departman seçiniz', 'name', 'name');
        $categories = WishCategory::toSelect('Dilek kategorisi seçiniz');

        return view('admin.child.edit',
            compact('child', 'users', 'diagnosises', 'faculties', 'departments', 'categories'));
    }

    public function update(Request $request, Child $child)
    {
        $this->authorize('update', $child);
        $this->validateResource($request);

        $data = $request->only([
            'department', 'first_name', 'last_name', 'diagnosis', 'diagnosis_desc', 'taken_treatment', 'child_state',
            'child_state_desc', 'gender', 'meeting_day', 'birthday', 'wish', 'g_first_name', 'g_last_name', 'g_mobile',
            'g_email', 'province', 'city', 'address', 'extra_info', 'until', 'gift_state', 'faculty_id',
            'wish_category_id'
        ]);
        $data['is_name_public'] = $request->has('is_name_public');
        $data['is_diagnosis_public'] = $request->has('is_diagnosis_public');
        $child->update($data);
        $child->updateSlug();

        $child->users()->sync($request->users);

        $post = $child->meetingPost;
        $post->change($request, 'meeting');
        $child->meetingPost()->associate($post);
        $child->save();

        if ($request->has('has_delivery_post') && $request->delivery_text && trim(strip_tags($request->delivery_text))) {
            $post = $child->deliveryPost;
            $post->change($request, 'delivery');
            $child->deliveryPost()->associate($post);
            $child->save();
        }

        if (!$child->featuredMedia) {
            $child->featuredMedia()->associate($child->meetingPost->getFirstMedia());
            $child->save();
        }

        if ($request->hasFile('verification_doc')) {
            $child->addVerificationDoc($request->file('verification_doc'));
        }

        $url = route("front.child", [$child->faculty->slug, $child->slug]);
        session_success("<strong>{$child->full_name}</strong> başarıyla güncellendi. <a href='{$url}' class='text-bold' target='_blank' >Sitede görüntüle</a>");

        return redirect()->route('admin.child.edit', $child->id);
    }

    public function destroy(Child $child)
    {
        $this->authorize('delete', $child);

        $child->meetingPost()->delete();
        $child->deliveryPost()->delete();
        $child->processes()->delete();
        $child->chats()->delete();

        $this->processService->create($child, ProcessType::Deleted);
        $this->feedService->create(
            $child->faculty,
            FeedType::ChildDeleted,
            ['child' => $child->full_name, 'user' => auth()->user()->full_name]
        );

        $child->delete();

        return api_success(['child' => $child]);
    }

    // HELPERS
    private function checkSimilarChildren($firstName, $lastName, $accepted)
    {
        $similarChildren = $this->getSimilarChildren($firstName, $lastName);
        if ($accepted == '0' && $similarChildren->isNotEmpty()) {
            $message = $similarChildren->reduce(function ($carry, $child) {
                $carry .= '<p>';
                $carry .= "<strong>Çocuk: </strong> {$child->full_name}<br>";
                $carry .= "<strong>Fakülte: </strong> {$child->faculty->full_name}<br>";
                $carry .= '<strong>Sorumlular: </strong>';
                $carry .= $child->users->implode(', ', 'full_name');
                $carry .= '</p>';

                return $carry;
            }, '');

            session_error("Başka fakültelerde {$firstName} {$lastName} isimde çocuk bulunmaktadır");

            abort(redirect()->back()->withInput()->with('similarChildren', $message));
        }
    }

    private function getSimilarChildren($first_name, $last_name)
    {
        return Child::query()->where('first_name', 'like', "%{$first_name}%")
            ->where('last_name', 'like', "%{$last_name}%")->with('users', 'faculty')->get();
    }

    private function validateResource(Request $request, $isUpdate = false)
    {
        $this->validate($request, [
            'meeting_day' => 'required|date|date_format:d.m.Y',
            'birthday'    => 'required|date|date_format:d.m.Y',
            'until'       => 'required|date|date_format:d.m.Y',
        ]);
    }

}

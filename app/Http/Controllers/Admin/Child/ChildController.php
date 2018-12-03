<?php

namespace App\Http\Controllers\Admin\Child;

use App\Enums\FeedType;
use App\Enums\ProcessType;
use App\Http\Controllers\Admin\AdminController;
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

class ChildController extends AdminController
{
    protected $processService;
    protected $feedService;

    public function __construct(ProcessService $processService, FeedService $feedService)
    {
        parent::__construct();
        $this->processService = $processService;
        $this->feedService = $feedService;
    }

    public function index(ChildFilter $filters)
    {
        $children = Child::with(['faculty'])->latest();
        $children->filter($filters);
        $children = $this->paginate($children);

        return view('admin.child.index', compact('children'));
    }

    public function create()
    {
        $faculties = Faculty::toSelect('Fakülte seçiniz');
        $users = auth()->user()->faculty->toUsersSelect();
        $diagnosises = Diagnosis::toSelect('Tanı seçiniz');
        $departments = Department::toSelect('Departman seçiniz');
        $categories = WishCategory::toSelect('Dilek kategorisi seçiniz');

        return view('admin.child.create', compact('faculties', 'users', 'diagnosises', 'departments', 'categories'));
    }

    public function store(CreateChildRequest $request)
    {
        $this->checkSimilarChildren($request->first_name, $request->last_name, $request->similarity_accept);

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
        $child->load('processes', 'meetingPost.media', 'deliveryPost.media');
        return view('admin.child.show', compact('child'));
    }

    public function edit(Child $child)
    {
        $faculties = Faculty::toSelect('Fakülte seçiniz');
        $users = auth()->user()->faculty->toUsersSelect();
        $diagnosises = Diagnosis::toSelect('Tanı seçiniz');
        $departments = Department::toSelect('Departman seçiniz');
        $categories = WishCategory::toSelect('Dilek kategorisi seçiniz');

        return view('admin.child.edit',
            compact('child', 'users', 'diagnosises', 'faculties', 'departments', 'categories'));
    }

    public function update(Request $request, Child $child)
    {
        $data = $request->only([
            'department', 'first_name', 'last_name', 'diagnosis', 'diagnosis_desc', 'taken_treatment', 'child_state',
            'child_state_desc', 'gender', 'meeting_day', 'birthday', 'wish', 'g_first_name', 'g_last_name', 'g_mobile',
            'g_email', 'province', 'city', 'address', 'extra_info', 'until', 'gift_state', 'faculty_id',
            'wish_category_id'
        ]);
        $data['is_name_public'] = $request->has('is_name_public');
        $data['is_diagnosis_public'] = $request->has('is_diagnosis_public');
        $child->update($data);

        $child->users()->sync($request->users);

        $child->meetingPost->change($request, 'meeting');

        if ($request->has('has_delivery_post') && $request->delivery_text && trim(strip_tags($request->delivery_text))) {
            $post = $child->deliveryPost;
            $post->change($request, 'delivery');
            $child->deliveryPost()->associate($post);
            $child->save();

        }

        if ($request->hasFile('verification_doc')) {
            $child->addVerificationDoc($request->file('verification_doc'));
        }

        session_success("<strong>{$child->full_name}</strong> başarıyla güncellendi.");

        return redirect()->route('admin.child.edit', $child->id);
    }

    public function destroy(Child $child)
    {
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
}

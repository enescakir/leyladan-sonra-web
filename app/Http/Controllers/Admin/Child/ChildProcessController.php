<?php

namespace App\Http\Controllers\Admin\Child;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\ProcessService;
use App\Services\FeedService;
use App\Models\Child;

class ChildProcessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Child $child)
    {
        $this->authorize('process', [$child, $request->type]);

        $process = ProcessService::create($child, $request->type);
        $feed = FeedService::fromProcess($process);

        $process->loadMissing('creator');

        return api_success([
            'process'          => $process,
            'label'            => $child->gift_state_label,
            'created_at_label' => $process->created_at_label
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\GiftStatus;
use App\Enums\PostType;
use App\Enums\UserTitle;
use App\Http\Requests\CreateChildRequest;

use App\Child, App\Faculty, App\User, App\Post, App\PostImage, App\Process,
    App\Feed, App\Chat, App\Diagnosis, App\Volunteer;
use Auth, Carbon\Carbon, File, Datatables;

class ChildController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    return view('admin.child.index');
  }

  public function indexData()
  {
    return Datatables::of(Child::select('id','faculty_id','department', 'diagnosis', 'first_name','last_name','wish','birthday','meeting_day','gift_state')->with('faculty')->get())
    ->editColumn('operations', '
      <a class="edit btn btn-primary btn-sm" href="{{ route("admin.child.show", $id) }}"><i class="fa fa-search"></i></a>
      <a class="edit btn btn-success btn-sm" href="{{ route("admin.child.edit", $id) }}"><i class="fa fa-pencil"></i></a>
      <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>'
    )
    ->editColumn('gift_state','
      @if ($gift_state == "Bekleniyor")
        <td><span class="label label-danger"> Bekleniyor </span></td>
      @elseif ($gift_state == "Yolda")
        <td><span class="label label-warning"> Yolda </span></td>
      @elseif ($gift_state == "Bize Ulaştı")
        <td><span class="label label-primary"> Bize Ulaştı </span></td>
      @elseif ($gift_state == "Teslim Edildi")
        <td><span class="label label-success"> Teslim Edildi </span></td>
      @else
        <td><span class="label label-default"> Problem </span></td>
      @endif'
    )
    ->editColumn('birthday','{{date("d.m.Y", strtotime($birthday))}}')
    ->editColumn('meeting_day','{{date("d.m.Y", strtotime($meeting_day))}}')
    ->make(true);
  }


  public function create()
  {
    $authUser = Auth::user();
    $faculties = Faculty::all();
    $users = $authUser->faculty->usersToSelect();
    $diagnosis = Diagnosis::toSelect(true);
    return view('admin.child.create', compact(['faculties','authUser', 'users', 'diagnosis']));
  }

  public function store(CreateChildRequest $request)
  {
    if ($this->checkSimilarChildren($request)) {
      return $this->sendSimilarChildrenResponse($request)
    }
    $user = Auth::user();
    $child = $this->createChild$request();
    $child->users()->attach($request->users);
    $child->updateSlug();
    if ( $request->hasFile('verification_doc') ){
      $child->uploadImage($request->file('verification_doc'), 'verification_doc', 'verification', 1500);
    }
    $post = $this->createPost($request, $child);
    $post->addImage(
      $request->file('website_image'),
      $request->only(['ratio', 'rotation', 'w', 'h', 'x', 'y'])
    );
    success_message($child->first_name . ' başarıyla sisteme eklendi.');

    $child->processes()->attach(
      Process::create([
        'desc' => 'Çocuk sisteme girildi.';
      ])
    );
    // TODO: Check processes save

    Feed::create([
      'faculty_id' => $child->faculty_id,
      'title' => UserTitle::All,
      'desc' =>  $child->full_name . " ile tanışıldı.",
      'icon' => 1
    ]);
    return redirect()->route('admin.user.children', $user->id );
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $child = Child::with('faculty','users','processes')->find($id);
    $meeting_post = Post::meetingPost($child->id)->with('images')->first();
    $gift_post = Post::giftPost($child->id)->with('images')->first();
    return view('admin.child.show', compact(['child','meeting_post', 'gift_post']));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $authUser = Auth::user();
    $child = Child::with('users')->find($id);
    $users = $authUser->faculty->usersToSelect();
    $diagnosis = Diagnosis::toSelect(true);
    $faculties = Faculty::all('full_name','id');
    $faculty = Faculty::findOrFail($child->faculty_id);
    $meeting_post = Post::meetingPost($child->id)->with('images')->first();
    $gift_post = Post::giftPost($child->id)->with('images')->first();
    $selectedUser = $child->users->pluck('id')->toArray();
    return view('admin.child.edit', compact(['authUser','users','faculties', 'child','faculty','meeting_post', 'gift_post','selectedUser', 'diagnosis']));

  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {

    $child = Child::find($id);
    //        Session::flash('success_message', $child->first_name . ' başarıyla sisteme eklendi.');
    //        return redirect()->back()->withInput();
    $child->update($request->except(['users', 'website_text', 'website_image','delivered_text','delivered_image', 'ratio1', 'rotation1','x1','y1','w1','h1', 'ratio2', 'rotation2','x2','y2','w2','h2','verification_doc']));
    $child->users()->sync($request->get('users'));

    $faculty = Faculty::find($child->faculty_id);

    $meeting_post = Post::meetingPost($child->id)->first();
    if($meeting_post == null){
      $meeting_post = new Post();
      $meeting_post->child_id = $child->id;
      $meeting_post->type = "Tanışma";
    }
    $meeting_post->text = $request->website_text;
    $meeting_post->save();

    if($request->hasFile('website_image')){

      $imageSize = 800;
      if ($request->ratio1 == '2/3'){
        $imageSize = 400;
      }

      if( count($meeting_post->images) == 0){
        $meetingPostImage = new PostImage();
        $meetingPostImage->post_id = $meeting_post->id;
        $meetingPostImage->name = $child->id . '_1.jpg';
        $meetingPostImage->ratio = $request->ratio1;
        $meetingPostImage->save();
      }else{
        $meetingPostImage = $meeting_post->images()->first();
        $meetingPostImage->ratio = $request->ratio1;
        $meetingPostImage->save();
      }

      ini_set("memory_limit","-1");

      $imgPost = Image::make($request->file('website_image'))
      ->rotate(-$request->rotation1)
      ->crop($request->w1, $request->h1, $request->x1, $request->y1)
      ->resize($imageSize, null, function ($constraint) {
        $constraint->aspectRatio();
      })
      ->save('resources/admin/uploads/child_photos/' . $meetingPostImage->name, 80);

      ini_restore("memory_limit");

    }
    $meeting_post->save();

    $gift_post = Post::giftPost($child->id)->first();
    if($gift_post == null && ($request->delivered_text != null && $request->delivered_text != '')){
      $gift_post = new Post;
      $gift_post->child_id = $child->id;
      $gift_post->type = "Hediye";
      $gift_post->text = $request->get('delivered_text');
      $gift_post->save();
    }
    else if($request->delivered_text != null && $request->delivered_text != ''){
      $gift_post->text = $request->get('delivered_text');
      $gift_post->save();
    }


    if($request->hasFile('delivered_image')){
      $child->gift_state = 'Teslim Edildi';
      if($gift_post == null){
        $gift_post = new Post;
        $gift_post->child_id = $child->id;
        $gift_post->type = "Hediye";
        $gift_post->text = '';
        $gift_post->save();
      }

      if( count($gift_post->images) == 0){
        $giftPostImage = new PostImage();
        $giftPostImage->post_id = $gift_post->id;
        $giftPostImage->name = $child->id . '_2.jpg';
        $giftPostImage->ratio = $request->ratio2;
        $giftPostImage->save();
      }else{
        $giftPostImage = $gift_post->images()->first();
        $giftPostImage->ratio = $request->ratio2;
        $giftPostImage->save();
      }


      ini_set("memory_limit","-1");
      $imgPost = Image::make($request->file('delivered_image'))
      ->rotate(-$request->rotation2)
      ->crop($request->w2, $request->h2, $request->x2, $request->y2)
      ->resize(800, null, function ($constraint) {
        $constraint->aspectRatio();
      })
      ->save('resources/admin/uploads/child_photos/' . $giftPostImage->name, 80);
      ini_restore("memory_limit");

    }

    if($request->hasFile('verification_doc') ){
      $verificationDoc = Image::make($request->file('verification_doc'))
      ->resize(1500, null, function ($constraint) {
        $constraint->aspectRatio();
      })
      ->save('resources/admin/uploads/verification_docs/' . $child->id . '_ver.jpg', 80);
      $child->verification_doc =  $child->id . '_ver.jpg';
    }
    $child->save();
    return redirect()->route('admin.child.show', $child->id);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $child = Child::find($id);
    $posts = $child->posts;
    foreach( $posts as $post){
      foreach( $post->images as $image){
        File::delete('resources/admin/uploads/child_photos/' . $image->name);
        $image->delete();
      }
      $post->delete();
    }
    File::delete('resources/admin/uploads/verification_docs/' . $child->verification_doc);
    Process::where('child_id', $id)->delete();
    $desc = Auth::user()->full_name . ", " . $child->full_name . " isimli çocuğunuzu sildi.";
    $feed = new Feed([
      'desc' => $desc,
      'icon' => '4',
      'faculty_id' => $child->faculty_id,
      'title' => 'All'
    ]);
    $feed->save();

    $child->delete();
    //TODO: Add chats, socials
    return http_response_code(200);
  }

  public function volunteered(Request $request, $id){
    $child = Child::find($id);
    if( $child == null)
    abort(404);

    $volunteer = Volunteer::find($request->volunteer_id);

    $child->volunteer_id = $request->volunteer_id;
    $child->gift_state = 'Yolda';
    if($child->save()){
      $process = new Process;
      $process->created_by = Auth::user()->id;
      $process->child_id = $child->id;
      $process->desc = $volunteer->first_name . ' ' . $volunteer->last_name .' gönüllü olarak belirlendi.';
      $process->save();
    }


    return json_encode( ['message' => $child->first_name . " gönüllüsü " . $volunteer->first_name . " olarak güncellendi."]);
  }

  public function chats(Request $request, $id){
    $child = Child::find($id);
    $chats = $child->chats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id','desc')->get();
    return $chats;
  }

  public function chat($id, $chatID){
    $chat = Chat::where('id', $chatID)->with('messages', 'volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift', 'messages.sender', 'messages.answerer')->first();
    return $chat;
  }

  public function chatsOpens(Request $request, $id){
    $child = Child::find($id);
    $chats = $child->openChats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id','desc')->get();
    return $chats;
  }

  public function createProcess(Request $request)
  {
    $user = Auth::user();
    $process = new Process;
    $process->created_by = $user->id;
    $process->child_id = $request->child_id;
    $process->desc = $request->desc;
    $process->save();
    if($request->type == 1){
      $child = Child::find($process->child_id);
      $child->gift_state = 'Bize Ulaştı';
      $child->save();

      $users = $child->users;
      foreach ($users as $value) {
        // TODO: Add Notification
        // \Mail::send('email.admin.giftarrival', ['user' => $value, 'child' => $child], function ($message) use ($value, $child) {
        //     $message
        //         ->to($value->email)
        //         ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
        //         ->subject('Çocuğunuzun hediyesi bize ulaştı.');
        // });
      }


      $feed = new Feed;
      $feed->desc = $child->full_name . " hediyesi geldi.";
      $feed->icon = 3;
      $feed->faculty_id = $child->faculty_id;
      $feed->title = "All";
      $feed->save();

    }
    else if($request->type == 2){
      $child = Child::find($process->child_id);
      $child->gift_state = 'Yolda';
      $child->save();

      $feed = new Feed;
      $feed->desc = $child->full_name . " için gönüllü bulundu.";
      $feed->icon = 2;
      $feed->faculty_id = $child->faculty_id;
      $feed->title = "All";
      $feed->save();

    }
    else if($request->type == 3){
      $child = Child::find($process->child_id);
      $child->gift_state = 'Teslim Edildi';
      $child->save();

      $feed = new Feed;
      $feed->desc = $child->full_name . " hediyesi teslim edildi.";
      $feed->icon = 2;
      $feed->faculty_id = $child->faculty_id;
      $feed->title = "All";
      $feed->save();

    }
    else if($request->type == 4){
      $child = Child::find($process->child_id);
      $child->gift_state = 'Bekleniyor';
      $child->save();

      $feed = new Feed;
      $feed->desc = $child->full_name . ' hediye durumu "Bekleniyor" olarak güncellendi.';
      $feed->icon = 2;
      $feed->faculty_id = $child->faculty_id;
      $feed->title = "All";
      $feed->save();

    }
    return Process::whereId($process->id)->with('creator')->first();
  }

  // CREATES
  public function createChild(Request $request)
  {
    return Child::create([
      'faculty_id'       => $request->faculty_id,
      'department'       => $request->department,
      'first_name'       => $request->first_name,
      'last_name'        => $request->last_name,
      'diagnosis'        => $request->diagnosis,
      'diagnosis_desc'   => $request->diagnosis_desc,
      'taken_treatment'  => $request->taken_treatment,
      'child_state'      => $request->child_state,
      'child_state_desc' => $request->child_state_desc,
      'gender'           => $request->gender,
      'meeting_day'      => Carbon::createFromFormat('d.m.Y', $request->meeting_day),
      'birthday'         => Carbon::createFromFormat('d.m.Y', $request->birthday),
      'wish'             => $request->wish,
      'g_first_name'     => $request->g_first_name,
      'g_last_name'      => $request->g_last_name,
      'g_mobile'         => $request->g_mobile,
      'g_email'          => $request->g_email,
      'province'         => $request->province,
      'city'             => $request->city,
      'address'          => $request->address,
      'extra_info'       => $request->extra_info,
      'gift_state'       => GiftStatus::Waiting,
      'until'            => Carbon::createFromFormat('d.m.Y', $request->meeting_day)->addYear(),
    ]);
  }

  public function createPost(Request $request, Child $child)
  {
    return Post::create([
      'child_id' => $child->id,
      'text'     => $request->website_text,
      'type'     => PostType::Meeting,
    ]);
  }

  // HELPERS
  public function checkSimilarChildren(Request $request)
  {
    return
    $request->accepted == '0' &&
    count( $this->getSimilarChildren($request->first_name, $request->last_name) ) > 0 ;
  }

  public function getSimilarChildren($first_name, $last_name)
  {
    return Child::
      where('first_name', 'like', '%' . $first_name . '%')
      ->where('last_name', 'like', '%' . $last_name . '%')
      ->with('users', 'faculty')
      ->get();
  }

  public function sendSimilarChildrenResponse($request)
  {
    $similarChildren = $this->getSimilarChildren($request->first_name, $request->last_name);
    $message = "";
    foreach($similarChildren as $similarChild){
      $message .= "<p>";
      $message .= "<strong>Çocuk: </strong>" . $similarChild->full_name . "<br>";
      $message .= "<strong>Fakülte: </strong>" . $similarChild->faculty->full_name . " Tıp Fakültesi<br>";
      $message .= "<strong>Sorumlular: </strong>";
      $message .= $similarChild->users->implode(", ", "full_name");
      $message .= "</p>";
    }
    error_message('Bu isimde çocuk var.');
    return redirect()->back()->withInput()->with('similarChildren', $message);
  }

}

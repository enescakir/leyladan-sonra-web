<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\ActivateEmail as ActivateEmailNotification;
use App\Notifications\NewUser as NewUserNotification;
use App\Notifications\ApprovedUser as ApprovedUserNotification;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Image\Manipulations;
use App\Scopes\GraduateScope;
use App\Scopes\LeftScope;
use App\Traits\Birthday;
use App\Traits\Mobile;
use App\Traits\Base;
use App\Traits\Approval;
use Auth;
use Excel;

class User extends Authenticatable implements HasMedia
{
    use Base;
    use Birthday;
    use Mobile;
    use Approval;
    use Notifiable;
    use HasRoles;
    use HasMediaTrait;

    // Properties
    protected $table = 'users';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'birthday', 'mobile',
        'year', 'title', 'profile_photo', 'faculty_id', 'gender', 'email_token',
        'left_at', 'graduated_at', 'approved_at', 'approved_by'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['full_name'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'birthday', 'left_at', 'graduated_at', 'approved_at'];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GraduateScope);
        static::addGlobalScope(new LeftScope);
    }

    // Relations
    public function children()
    {
        return $this->belongsToMany(Child::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class, 'created_by');
    }

    public function answers()
    {
        return $this->hasMany(Message::class, 'answered_by');
    }

    public function visits()
    {
        return $this->hasMany(Process::class, 'created_by')->where('desc', ProcessType::Visit);
    }

    // Scopes
    public function scopeTitle($query, $title)
    {
        $query->where('title', $title);
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%')
                    ->orWhere(\DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getRoleDisplayAttribute()
    {
        return $this->roles->pluck('display')->implode(', ');
    }

    public function getPhotoSmallUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'small') ?: admin_asset('img/user-default-small.png');
    }

    public function getPhotolUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'medium') ?: admin_asset('img/user-default-medium.png');
    }

    public function getPhotoLargeUrlAttribute()
    {
        return $this->getFirstMediaUrl('default', 'large') ?: admin_asset('img/user-default-large.png');
    }

    // Helpers
    public function activateEmail()
    {
        $this->email_token = null;
        return $this->save();
    }

    public static function toSelect($placeholder = null)
    {
        $res = static::orderBy('id', 'DESC')->get()->pluck('full_name', 'id');
        return $placeholder ? collect(['' => $placeholder])->union($res) : $res;
    }

    public static function download($users)
    {
        $users = $users->get();
        Excel::create('LS_Uyeler_' . date('d_m_Y'), function ($excel) use ($users) {
            $usersData = $users->map(function ($item, $key) {
                return [
                    'ID'           => $item->id,
                    'Ad'           => $item->first_name,
                    'Soyad'        => $item->last_name,
                    'E-posta'      => $item->email,
                    'Telefon'      => $item->mobile,
                    'Fakülte'      => $item->faculty->name,
                    'Görev'        => $item->role_display,
                    'Kayıt Tarihi' => $item->created_at,
                ];
            });
            $excel->sheet('Uyeler', function ($sheet) use ($usersData) {
                $sheet->fromArray($usersData, null, 'A1', true);
            });
        })->download('xlsx');
    }

    // Notifications
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailActivationNotification()
    {
        $token = hash_hmac('sha256', str_random(40), $this->email);
        $this->email_token = $token;
        $this->save();
        $this->notify(new ActivateEmailNotification($token));
    }

    public function sendNewUserNotification($user)
    {
        $this->notify(new NewUserNotification($user));
    }

    public function sendApprovedUserNotification()
    {
        $this->notify(new ApprovedUserNotification());
    }

    // Image conversions
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('small')->fit(Manipulations::FIT_CROP, 64, 64);
        $this->addMediaConversion('medium')->fit(Manipulations::FIT_CROP, 256, 256);
        $this->addMediaConversion('large')->fit(Manipulations::FIT_CROP, 512, 512);
    }
}

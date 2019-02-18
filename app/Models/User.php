<?php

namespace App\Models;

use App\Support\Role;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check whether this user is pegawai or not
     * @return bool
     */
    public function isPegawai()
    {
        return ($this->role == Role::PEGAWAI);
    }

    /**
     * Check whether this user is pengolah or not
     * @return bool
     */
    public function isPengolah()
    {
        return ($this->role == Role::PENGOLAH);
    }

    /**
     * Check whether this user is kadin or not
     * @return bool
     */
    public function isKadin()
    {
        return ($this->role == Role::KADIN);
    }

    /**
     * Check whether this user is TU or not
     * @return bool
     */
    public function isTU()
    {
        return ($this->role == Role::TU);
    }

    public function getSuratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'user_id');
    }

    public function getSuratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'user_id');
    }

    public function scopeByActivationColumns(Builder $builder, $email, $verifyToken)
    {
        return $builder->where('email', $email)->where('verifyToken', $verifyToken);
    }

    /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPassword($token));
    }
}

class CustomPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'), env("APP_NAME") . ' | Aplikasi Pengarsipan Surat dan Disposisi')
            ->subject('APSD Account: Reset Password')
            ->line('Kami mengirimkan email ini karena kammi menerima sebuah permintaan lupa password.')
            ->action('Reset Password', url(route('password.reset', $this->token, false)))
            ->line('Jika Anda tidak melakukan reset password, mohon menghubungi kami.');
    }
}
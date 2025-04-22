@component('mail::message')
# Halo, {{ $user->name }}

Akun Anda telah berhasil dibuat oleh Admin.

**Email:** {{ $user->email }}

Silakan login menggunakan email dan password yang telah diberikan oleh Admin.

@component('mail::button', ['url' => url('/')])
Login ke Sistem
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent

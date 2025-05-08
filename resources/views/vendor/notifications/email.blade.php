@component('mail::message')
# Reset Password

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda di NoFoodWaste.

@component('mail::button', ['url' => route('password.reset', $token)])
Reset Password
@endcomponent

Link reset password ini akan kedaluwarsa dalam {{ config('auth.passwords.users.expire') }} menit.

Jika Anda tidak meminta reset password, tidak ada tindakan lebih lanjut yang diperlukan.

Salam,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Jika Anda mengalami masalah saat mengklik tombol "Reset Password", salin dan tempel URL berikut
ke browser web Anda: {{ route('password.reset', $token) }}
@endcomponent
@endcomponent
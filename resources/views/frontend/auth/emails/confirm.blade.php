Your password is: {!! $password !!}<br />
{{ trans('strings.frontend.email.confirm_account') . ' ' . url('account/confirm/' . $token) }}
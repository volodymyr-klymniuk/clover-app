<?php

namespace App;

final class Events
{
    public const USER_COMPANY_CREATED = 'user.company.created';
    public const USER_CREATED = 'user.created';

    public const USER_RECOVER_PASSWORD_REQUESTED = 'user.recover_password.requested';
    public const USER_RECOVER_PASSWORD_FAILED = 'user.recover_password.failed';
    public const USER_RECOVER_PASSWORD_SUCCESSFUL = 'user.recover_password.successful';
    public const USER_AUTHENTICATION_SUCCESSFUL = 'user.authentication.successful';
    public const USER_AUTHENTICATION_FAILED = 'user.authentication.failed';
    public const USER_AUTHORIZATION_FAILED = 'user.authorization.failed';
}

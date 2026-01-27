<?php

namespace App\Enums;

enum ErrorMessage: string 
{
    case NOT_FOUND = 'Not found.';
    case INVALID_ULID = 'Invalid ULID.';
    case VALIDATION_FAILED = 'Validation failed.';
    case FAILED_TO_CREATE_TOKEN = 'Failed to create token.';
    case FAILED_TO_REFRESH_TOKEN = 'Failed to refresh token.';
    case TOKEN_REFRESH_SUCCESS = 'Token refreshed.';
    case TOKEN_CANNOT_BE_REFRESHED = 'Token expired, cannot be refreshed.';

    case LOGIN_SUCCESS = 'Logged in successfully';
    case LOGIN_FAILED = 'Login failed.';
    case LOGOUT_SUCCESS = 'Logged out successfully.';
    case LOGOUT_FAILED = 'Failed to logout, please try again.';
    case WRONG_USERNAME_OR_PASSWORD = 'Wrong username or password.';

    case USER_NOT_FOUND = 'User not found.';

    case PRODUCT_CREATED = 'Product created successfully.';
}

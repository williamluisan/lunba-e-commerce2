<?php

namespace App\Enums;

enum Message: string 
{
    case NOT_FOUND = 'Not found.';
    case INVALID_ULID = 'Invalid ULID.';
    case VALIDATION_FAILED = 'Validation failed.';
    case FAILED_TO_CREATE_TOKEN = 'Failed to create token.';
    case FAILED_TO_REFRESH_TOKEN = 'Failed to refresh token.';
    case TOKEN_CANNOT_BE_REFRESHED = 'Token expired, cannot be refreshed.';
    case TOKEN_REFRESH_SUCCESS = 'Token refreshed.';

    case LOGIN_FAILED = 'Login failed.';
    case LOGOUT_FAILED = 'Failed to logout, please try again.';
    case WRONG_USERNAME_OR_PASSWORD = 'Wrong username or password.';
    case LOGIN_SUCCESS = 'Logged in successfully';
    case LOGOUT_SUCCESS = 'Logged out successfully.';
    
    case USER_NOT_FOUND = 'User not found.';
    case PRODUCT_CREATED = 'Product created successfully.';
}

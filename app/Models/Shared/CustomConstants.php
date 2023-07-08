<?php

namespace App\Models\Shared;

class CustomConstants
{

    CONST CLIENT_ROLE_ID = 2;
    CONST CLIENT_USERTYPE_ID = 2;

    //status
    CONST RESPONSE_STATUS_SUCCESS = 1;
    CONST RESPONSE_STATUS_FAILED = 2;
    CONST RESPONSE_STATUS_PAYLOAD_VALIDATION_FAIL = 3;
    CONST RESPONSE_STATUS_RECORD_NOT_FOUND = 4;

    //messages
    CONST RESPONSE_MESSAGE_SUCCESS = 'Success';
    CONST RESPONSE_MESSAGE_FAILED = 'Failed';
    CONST RESPONSE_MESSAGE_PAYLOAD_VAIDATION_FAIL = 'Data validation failed';
    CONST RESPONSE_MESSAGE_RECORD_NOT_FOUND = 'Record not found';
    CONST RESPONSE_MESSAGE_RECORD_EXISTS = 'Record already exists';
    CONST RESPONSE_MESSAGE_INVALID_LOGIN_CREDENTIALS = 'Invalid login credentials';
    const RESPONSE_MESSAGE_USERNAME_TAKEN = 'Username already exist';
    const RESPONSE_MESSAGE_USERNAME_AVAILABLE = 'Username Available';


    //status
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    const STATUS_DEACTIVATED = 3;
    const STATUS_ACTIVATED = 4;
    const STATUS_PENDING = 5;
    const STATUS_COMPLETED = 6;
    const STATUS_REJECTED = 7;

    //file types
    const COMMUNICATION_SMS_PROVIDER_BONGA = 1;
    const COMMUNICATION_SMS_PROVIDER_AFRICAS_TALKING = 2;

    //subscription user band pricing
    CONST RESPONSE_MESSAGE_ERROR_CREATING_SUBSCRIPTION_USER_BAND_PRICING = 'Error creating subscription user band pricing';
    CONST RESPONSE_MESSAGE_ERROR_DELETING_SUBSCRIPTION_USER_BAND_PRICING = 'Error deleting subscription user band pricing';
    CONST RESPONSE_MESSAGE_SUCCESS_CREATING_SUBSCRIPTION_USER_BAND_PRICING = 'Subscription user band pricing created successfully';
    CONST RESPONSE_MESSAGE_SUCCESS_DELETING_SUBSCRIPTION_USER_BAND_PRICING = 'Subscription user band pricing deleted successfully';

    //Subscription
    const RESPONSE_MESSAGE_SUCCESS_CREATING_SUBSCRIPTION =  'Subscription created successfully';

    //Role types
    const ADMIN_ROLE_TYPE = 1;
    const SYSTEM_ROLE_TYPE = 2;
    const USER_DEFINED_ROLE_TYPE = 3;

    //Communication types
    const COMMUNICATION_TYPE_EMAIL = 'email';
    const COMMUNICATION_TYPE_SMS = 'sms';

    //Subscriptions grace periods
    const SUBSCRIPTION_START_DATE = 1;
    const SUBSCRIPTION_NOTIFICATION = 2;
    const SUBSCRIPTION_TERMINATION = 3;

    const PAYMENT_MODE_CLIENT_CREDIT = 6;

    const ROLE_IS_VISIBLE = 1;
    const ROLE_IS_NOT_VISIBLE = 0;
}

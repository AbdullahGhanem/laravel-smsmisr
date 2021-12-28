<?php

return [
    /*
     * SMSMISR_ENDPOINT
     */
    'endpoint' => env('SMSMISR_ENDPOINT', 'https://smsmisr.com/api/'),

    /*
     * SMSMISR_USERNAME
     */
    'username' => env('SMSMISR_USERNAME'),

    /*
     * SMSMISR_PASSWORD
     */
    'password' => env('SMSMISR_PASSWORD'),

    /*
     * SMSMISR_FROM
     */
    'sender' => env('SMSMISR_SENDER'),

    /*
     * SMSMISR_M_SIGNATURE
     */
    'm_signature' => env('SMSMISR_M_SIGNATURE'),

    /*
     * SMSMISR_TOKEN
     */
    'token' => env('SMSMISR_TOKEN'),

    /*
     * SMSMISR_SMS_ID
     */
    'sms_id' => env('SMSMISR_SMS_ID', 4945703),

    /*
     * SMSMISR_SMS_VERIFY_ID
     */
    'sms_verify_id' => env('SMSMISR_SMS_ID', 72973),
];

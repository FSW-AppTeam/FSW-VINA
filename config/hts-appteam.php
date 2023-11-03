<?php

return [
    /*
     * Enable logging, useful for debugging
     */
    'enable_logging' => true,

    /*
     * saml, oidc or local
     */
    'login_type' => [
        'oidc'
    ],

    /*
     * The field used in the database to identify a user
     */
    'user_identifier_key' => env('AUTH_USER_IDENTIFIER_KEY', 'solis_id'),

    /**
     * Urls which are ignored in the auth middleware. These urls should be application specific urls.
     * urls defined in exclude_urls_for_auth checked on exact match.
     * urls defined in exclude_urls_for_auth_wildcard are only compared to the first part of the string.
     * This variable you probably only use for url with a token.
     */
    'exclude_urls_for_auth' => [
        // Example:
        '/students',
    ],
    'exclude_urls_for_auth_wildcard' => [
        // Example:
        //'/students'
    ],

    /*
     * All SAML Settings
     */
    'saml_settings' => [
        /*
         * SAML SP Configuration
         */
        'saml_sp' => env('SAML_SP', 'default-sp'),

        /*
         * Are users which are not locally known allowed to use this application?
         */
        'allow_registration' => false,

        /*
         * Allow registration only based on these filters
         */
        'allow_registration_filter' => [
            [
                'attribute' => 'affiliation',
                'exp' => 'IS', // IN, IS, NOT_IN, NOT,
                'value' => 'employee'
            ]
        ],

        /*
         * Are users allowed to use this application anonymous?
         * This check is only done when user is not allowed to automatically register.
         * This is used for application where it is not required to store user data,
         * but we also want to limit access to users with a solis id.
         */
        'allow_anonymous' => false,

        /*
         * key/value pairs with attributes which are requested (i.e. not needed)
         * Keys are the saml attribute values we get back from the saml idp.
         * Values are the columns/fields in the application in the user model.
         * The migration is made dynamically, the defined values are created during the migration.
         */
        'requested_attributes' => [
            'uuShortID' => 'solis_id',
            'displayName' => 'name',
            'uuLegacyDepartment' => 'faculty',
            'department' => 'department',
            'mail' => 'email',
            'urn:mace:dir:attribute-def:eduPersonAffiliation' => 'affiliation'
        ],

        /*
         * list of attributes which are required (i.e. are needed)
         * During the migration, fields defined in this array are not nullable.
         */
        'required_attributes' => [
            'solis_id',
            'email',
            'affiliation'
        ],

        /*
         * list of attributes which must be unique
         */
        'unique_attributes' => [
            'solis_id',
            'email'
        ],

        /*
         * list of attributes which are not stored, but are used in the login.
         * For example in the 'allow_registration_filter'
         */
        'not_stored_attributes' => [
            'affiliation'
        ],
    ],

    /*
     * OIDC settings
     */
    'oidc_settings' => [
        /*
         * Basic OIDC client settings
         */
        'provider_url' => env('OIDC_PROVIDER_URL'),
        'client_id' => env('OIDC_CLIENT_ID'),
        'client_secret' => env('OIDC_CLIENT_SECRET'),

        /*
         * Default scopes
         */
        'scopes' => [
            'urn:uu.nl:idp:scope:oauth:fsw:appteam'
        ],

        /*
         * Enable 2FA
         */
        '2fa_enabled' => env('OIDC_2FA_ENABLED', false),

        /*
         * Are users allowed to use this application anonymous?
         * This check is only done when user is not allowed to automatically register.
         * This is used for application where it is not required to store user data,
         * but we also want to limit access to users with a solis id.
         */
        'allow_anonymous' => false,

        /*
         * Are users which are not locally known allowed to use this application?
         */
        'allow_registration' => false,

        /*
         * Allow registration only based on these filters
         */
        'allow_registration_filter' => [
            [
                'attribute' => 'locale',
                'exp' => 'IS', // IN, IS, NOT_IN, NOT,
                'value' => 'NL'
            ]
        ],

        /*
         * key/value pairs with attributes which are requested (i.e. not needed)
         * Keys are the OIDC attribute values we get back from the OIDC idp.
         * Values are the columns/fields in the application in the user model.
         * The migration is made dynamically, the defined values are created during the migration.
         */
        'requested_attributes' => [
            'uuShortID' => 'solis_id',
            'displayName' => 'name',
            'mail' => 'email'
        ],

        /*
         * list of attributes which are required (i.e. are needed)
         * During the migration, fields defined in this array are not nullable.
         */
        'required_attributes' => [
            'solis_id',
            'email',
            'name'
        ],

        /*
         * list of attributes which must be unique
         */
        'unique_attributes' => [
            'solis_id',
            'email'
        ],

        /*
         * list of attributes which are not stored, but are used in the login.
         * For example in the 'allow_registration_filter'
         */
        'not_stored_attributes' => [
//            'locale'
        ],
    ],

    /*
     * Local Login Settings
     */
    'local_settings' => [
        /*
         * For login_type = local we need a user fields mapping.
         * Key's are the names used in the application
         * The values are the fields used in the base package.
         */
        'user_model_mapping' => [
            'solis_id' => 'solis_id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password'
        ],

        /*
         * For login_type = local we can define which routes we want to use.
         */
        'login_route' => [
            'login'    => true,
            'logout'   => true,
            'register' => false,
            'reset'    => true,   // for resetting passwords
            // TODO: Confirm and verify is not finished jet.
            'confirm'  => false,  // for additional password confirmations
            'verify'   => false,  // for email verification
        ],

        /*
         * set local login to be only available for non UU users, this is useful
         * if you have multiple login types and you want to force UU users
         * to use SAML or OIDC login
         */
        'exclude_uu_users_from_local_login' => true
    ],
];

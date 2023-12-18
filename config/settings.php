<?php

/**
 * SETTING FIELD DATA
 */
return [
    'app' => [
        'title' => 'General',
        'desc' => 'All the general settings for Website.',
        'icon' => 'fas fa-cube',
        'elements' => [
            [
                'type' => 'text',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'agencyName', // unique name for field
                'label' => 'Nama Instansi',
                'rules' => 'required|min:2|max:100', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Instansi',
            ],
            [
                'type' => 'text',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'appName', // unique name for field
                'label' => 'Nama Website',
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Website Instansi',
            ],
            [
                'type' => 'file',
                'data' => 'image', // data type, string, int, boolean
                'name' => 'websiteLogo', // unique name for field
                'label' => 'Logo Website',
                'rules' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validation rule of laravel
                'class' => 'file-upload-info', // any class for input
                'value' => null,
            ],
            // [
            //     'type' => 'file',
            //     'data' => 'string', // data type, string, int, boolean
            //     'name' => 'headAgencyPhoto', // unique name for field
            //     'label' => 'Head of Agency Photo',
            //     'rules' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // validation rule of laravel
            //     'class' => 'file-upload-info', // any class for input
            //     'value' => null,
            // ],
            [
                'type' => 'textarea',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'webOverview', // unique name for field
                'label' => 'Kata Sambutan',
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '----',
            ],
            [
                'type' => 'textarea',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'agencyProfile', // unique name for field
                'label' => 'Profil Instansi',
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '----',
            ],
            [
                'type' => 'textarea',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'locationEmbed', // unique name for field
                'label' => 'Lokasi Embed Map',
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'https: //www.google.com/maps/embed?pb=xxx',
            ],
            [
                'type' => 'text',
                'data' => 'string', // data type, string, int, boolean
                'name' => 'footerText', // unique name for field
                'label' => 'Teks Footer',
                'rules' => 'required|min:2', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '<a href="#"> GhoribLaravel </a>',
            ],
            [
                'type' => 'checkbox',
                'data' => 'text', // data type, string, int, boolean
                'name' => 'showCopyRight', // unique name for field
                'label' => 'Tampilkan Copyright',
                'rules' => '', // validation rule of laravel
                'class' => 'custom-control-input', // any class for input
                'value' => '1',
            ],
        ],
    ],

    'contact' => [
        'title' => 'Contact',
        'desc' => 'Contact settings for website',
        'icon' => 'fas fa-envelope',
        'elements' => [
            [
                'type' => 'email', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'required|email', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'atra.lim@example.com', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'postalcode', // unique name for field
                'label' => 'Postal Code', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '(xxxxx)', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'phone', // unique name for field
                'label' => 'Phone/Fax', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '(xxxx) xxxxxxx', // default value if you want
            ],
        ],

    ],
    'address' => [
        'title' => 'Address',
        'desc' => 'Address settings for app',
        'icon' => 'fas fa-envelope',

        'elements' => [
            [
                'type' => 'textarea', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'address', // unique name for field
                'label' => 'Address', // you know what label it is
                'rules' => 'required|min:10|max:200', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Jl. Kenangan, Hayalan', // default value if you want
            ],
        ],

    ],

    'social' => [
        'title' => 'Social Profiles',
        'desc' => 'Link of all the social profiles.',
        'icon' => 'fas fa-users',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'facebook_url', // unique name for field
                'label' => 'Facebook Page URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'twitter_url', // unique name for field
                'label' => 'Twitter Profile URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'instagram_url', // unique name for field
                'label' => 'Instagram Account URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'linkedin_url', // unique name for field
                'label' => 'LinkedIn URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'youtube_url', // unique name for field
                'label' => 'Youtube Channel URL', // you know what label it is
                'rules' => 'required|nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
        ],

    ],
    'meta' => [
        'title' => 'Meta (SEO)',
        'desc' => 'Application Meta Data',
        'icon' => 'fas fa-globe-asia',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_site_name', // unique name for field
                'label' => 'Meta Site Name', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Awesome Laravel | A Laravel Starter Project', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_description', // unique name for field
                'label' => 'Meta Description', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Learning with laravel.', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_keyword', // unique name for field
                'label' => 'Meta Keyword', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Web Application, Web Instansi,Admin,Template,Open,Source', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_image', // unique name for field
                'label' => 'Meta Image', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/web_settings/banner.jpg', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_fb_app_id', // unique name for field
                'label' => 'Meta Facebook App Id', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '123456', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_twitter_site', // unique name for field
                'label' => 'Meta Twitter Site Account', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '@xxx', // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'text', // data type, string, int, boolean
                'name' => 'meta_twitter_creator', // unique name for field
                'label' => 'Meta Twitter Creator Account', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '@xxx', // default value if you want
            ],
        ],
    ],
    'analytics' => [
        'title' => 'Analytics',
        'desc' => 'Application Analytics',
        'icon' => 'fas fa-chart-line',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'google_analytics', // unique name for field
                'label' => 'Google Analytics', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'UA-XXXXXXXX-2', // default value if you want
            ],
        ],

    ],
];

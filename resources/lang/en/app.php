<?php

return [
    'meta' => [
        'title' => 'Anagata Executive | Where Data Meet Talent',
        'description' => 'Anagata Executive - Where Data Meet Talent. Headhunting, training, and outsourcing solutions powered by data-driven insights.',
    ],

    'language' => [
        'switcher_label' => 'Select language',
    ],

    'nav' => [
        'home' => 'Home',
        'about' => 'About',
        'services' => 'Services',
        'why_us' => 'Why Us',
        'contact' => 'Contact',
    ],

    'hero' => [
        'eyebrow' => 'Human Resources Recruitment Agency',
        'headline' => 'Where Talent Thrives & Culture Elevates',
        'description' => 'Discover top talent with speed, precision, and data-driven intelligence. Anagata Executive delivers end-to-end recruitment powered by AI, insight, and human expertise.',
        'cta' => 'Find a Job',
    ],

    'about' => [
        'title' => 'Excellence in Talent Acquisition',
        'description' => 'We deliver comprehensive recruitment solutions with a data-driven and technology enabled approach to ensure your organization\'s success. We are committed to finding the perfect fit for both our clients and candidates. By combining deep industry expertise, a personalized recruitment approach, and an extensive professional network, we identify and attract top talent with precision and care. Our process focuses not only on skills and experience, but also on cultural alignment and long-term potential, ensuring that every placement supports sustainable growth. Through this approach, we help companies build stronger teams while guiding candidates toward meaningful career opportunities.',
    ],

    'vision_mission' => [
        'title' => 'Our Vision & Mission',
        'subtitle' => 'Guiding principles that shape our commitment to excellence in talent acquisition',
        'vision_title' => 'Our Vision',
        'vision_body' => 'To become the most trusted and strategic talent partner in the industry, recognized for our ability to deliver exceptional talent solutions that drive organizational growth and success across diverse sectors.',
        'mission_title' => 'Our Mission',
        'mission_body' => 'To bridge the gap between exceptional talent and remarkable opportunities by leveraging cutting-edge technology, data-driven insights, and human expertise. We are committed to building lasting partnerships, delivering unparalleled value to our clients, and empowering candidates to achieve their career aspirations through meaningful placements that foster professional growth and organizational excellence.',
    ],

    'services' => [
        'title' => 'What We Offer',
        'description' => 'We provide comprehensive recruitment solutions tailored to your organization\'s unique needs. From executive leadership placements to specialized talent pipelines, our services combine data-driven insights with personalized expertise to deliver exceptional results that drive your business forward.',
        'cards' => [
            'executive' => 'Executive Search & Leadership Placement',
            'culture_fit' => 'Culture Fit Recruitment for Growing Startups',
            'pipeline' => 'Talent Pipeline Development for Specialized Roles',
        ],
    ],

    'why_us' => [
        'title' => 'Why Choose Us',
        'description' => 'We deliver comprehensive recruitment solutions with a data-driven and technology-enabled approach to ensure your organization\'s success.',
        'cards' => [
            'fast' => 'Fast & Efficient Hiring Process',
            'quality' => 'Higher Candidate Quality',
            'data' => 'Data-Driven Decision Making',
            'network' => 'Wide Talent Network',
            'culture' => 'Culture Fit Matching',
            'transparent' => 'Transparent & Accurate',
            'insights' => 'Labor Market Insights',
            'integration' => 'HR System Integration',
            'cost' => 'Cost Effective',
            'improvement' => 'Continuous Improvement',
        ],
    ],

    'contact' => [
        'title' => 'Talk to US',
        'subtitle' => 'Let us help you find the people who will shape your success. Contact us today',
        'form' => [
            'honeypot_label' => 'Company',
            'first_name_label' => 'First Name',
            'first_name_placeholder' => 'Enter your first name',
            'last_name_label' => 'Last Name (optional)',
            'last_name_placeholder' => 'Enter your last name',
            'email_label' => 'Email Address',
            'email_placeholder' => 'Enter your email address',
            'phone_label' => 'Phone Number',
            'phone_placeholder' => 'Enter your phone number',
            'message_label' => 'Message',
            'message_placeholder' => 'Tell us about your job interests, skills, experience, or what you\'re looking for',
            'submit' => 'Send Message',
        ],
        'validation' => [
            'first_name' => [
                'required' => 'First name is required',
                'min' => 'First name must be at least 4 characters',
                'max' => 'First name must not exceed 60 characters',
                'regex' => 'First name contains invalid characters',
            ],
            'last_name' => [
                'max' => 'Last name must not exceed 60 characters',
                'regex' => 'Last name contains invalid characters',
            ],
            'email' => [
                'required' => 'Email is required',
                'email' => 'Please enter a valid email address (e.g. name@example.com)',
                'max' => 'Email must not exceed 35 characters',
            ],
            'phone' => [
                'required' => 'Phone number is required',
                'min' => 'Phone number must be at least 10 characters',
                'max' => 'Phone number must not exceed 15 characters',
                'countryCode' => 'Please enter a valid country code in format (+X) or (+XX) before continuing',
                'regex' => 'Phone number must be in format (+X) YYYYYYYY or (+XX) YYYYYYYY (e.g. (+62) 81234567890, (+1) 2345678900)',
            ],
            'message' => [
                'required' => 'Message is required',
                'min' => 'Message must be at least 10 characters',
                'max' => 'Message must not exceed 2000 characters',
                'regex' => 'Message contains invalid characters',
            ],
        ],
    ],

    'toast' => [
        'success' => 'Success',
        'warning' => 'Warning',
        'error' => 'Something went wrong',
    ],

    'aria' => [
        'close_toast' => 'Close notification',
    ],

    'footer' => [
        'tagline' => 'Where Data Meet Talent',
        'nav_label' => 'Footer navigation',
        'rights' => 'All rights reserved.',
    ],
];


<?php

namespace App\Enums;

enum ProjectEnvironmentEnum: string
{
    case PRODUCTION = 'production';
    case STAGING = 'staging';
    case DEVELOPMENT = 'development';
    case TESTING = 'testing';
    case LOCAL = 'local';
}

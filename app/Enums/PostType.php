<?php

namespace App\Enums;

enum PostType: string
{
    case Project = 'project';
    case Tool = 'tool';
    case Joke = 'joke';
}

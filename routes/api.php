<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::resource('/tasks', 'TaskController')->except(['create', 'show', 'edit']);

Route::resource('/projects', 'ProjectController')->except(['create', 'show', 'edit']);

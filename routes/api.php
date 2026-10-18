<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Aqui importamos os controllers para o Laravel saber onde eles estão!
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AppointmentController;

// Suas rotas
Route::apiResource('users', UserController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('availabilities', AvailabilityController::class);
Route::apiResource('appointments', AppointmentController::class);
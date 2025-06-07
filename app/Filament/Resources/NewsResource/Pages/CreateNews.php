<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller\NewsController;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;
    
}

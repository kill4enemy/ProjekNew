<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class ApiDocs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'API Documentation';
    protected static ?string $title = 'API Documentation';
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.admin.pages.api-docs';
}

<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectReportResource\Pages;
use App\Filament\Admin\Resources\ProjectReportResource\RelationManagers;
use App\Models\ProjectReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProjectReportResource extends Resource
{
    protected static ?string $model = ProjectReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'Project Reports';

    protected static ?string $pluralModelLabel = 'Project Reports';

    protected static ?string $modelLabel = 'Project Report';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Project')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Project')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat / Solusi')
                            ->required()
                            ->rows(4),
                ]),
                Section::make('Analisis & Kebutuhan Sistem')
                    ->schema([
                        Textarea::make('problem_analysis')
                            ->label('Analisis Masalah')
                            ->required()
                            ->rows(6),

                        Textarea::make('system_requirements')
                            ->label('Kebutuhan Sistem & Fitur Utama')
                            ->required()
                            ->rows(6),
                ]),
                Section::make('Arsitektur & Tech Stack')
                ->schema([
                    Textarea::make('architecture')
                        ->label('Arsitektur Sistem')
                        ->required()
                        ->rows(5),

                    Textarea::make('tech_stack')
                        ->label('Tech Stack')
                        ->required()
                        ->rows(5),
                ]),
                Section::make('Progress & Diagram')
                ->schema([
                    Select::make('progress_status')
                        ->label('Status Progress')
                        ->options([
                            'draft' => 'Draft',
                            'in_progress' => 'In Progress',
                            'revision' => 'Revisi',
                            'completed' => 'Selesai',
                        ])
                        ->default('draft')
                        ->required(),

                    FileUpload::make('diagram_image')
                        ->label('ERD / Flowchart')
                        ->image()
                        ->directory('project-reports')
                        ->disk('public')
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Project')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('progress_status')
                    ->label('Progress')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'in_progress' => 'In Progress',
                        'revision' => 'Revisi',
                        'completed' => 'Selesai',
                        default => $state,
                    }),
                ImageColumn::make('diagram_image')
                    ->label('Diagram')
                    ->disk('public'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
         ])
                    
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectReports::route('/'),
            'create' => Pages\CreateProjectReport::route('/create'),
            'edit' => Pages\EditProjectReport::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassesResource\Pages;
use App\Filament\Resources\ClassesResource\RelationManagers;
use App\Models\Classes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification'; // Adjust icon as needed

    protected static ?string $navigationGroup = 'Class & Attendance';

    protected static ?int $navigationSort = 5; // Position after AcademicYearResource

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('class_name')->label('Class Name')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('grade_level')
                ->options([
                    1 => 'kelas-1',
                    2 => 'kelas-2',
                    3 => 'kelas-3',
                    4 => 'kelas-4',
                    5 => 'kelas-5',
                    6 => 'kelas-6',
                ])->native(false)->searchable()->preload()
                ->required(),
            Forms\Components\TextInput::make('section')
                ->maxLength(255),
            Forms\Components\Select::make('teacher_id')
                ->relationship('teacher', 'first_name')->native(false)->searchable()->preload()->required(),
            Forms\Components\Select::make('academic_year_id')
                ->relationship('academicYear', 'name')->native(false)->searchable()->preload()->required(),
            Forms\Components\TextInput::make('total_students'),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('class_name')->label('Class Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade_level'),
                Tables\Columns\TextColumn::make('section'),
                Tables\Columns\TextColumn::make('teacher.first_name') // Display teacher name
                    ->label('Teacher'),
                Tables\Columns\TextColumn::make('academicYear.name') // Display academic year name
                    ->label('Academic Year'),
             //   Tables\Columns\TextColumn::make('total_students'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
        ];
    }
}

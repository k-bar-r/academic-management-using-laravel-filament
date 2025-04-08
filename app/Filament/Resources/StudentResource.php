<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Section  as InfoSection;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Enums\FiltersLayout;
use App\Models\Classes;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'school management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    // Personal Details
                    Forms\Components\TextInput::make('first_name')->label('First Name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')->label('Last Name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('middle_name')->label('Middle Name')
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('date_of_birth')->label('Date of Birth')->native(false)
                        ->required(),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ])->native(false)
                        ->required(),

                    // Address and Contact Information
                    Forms\Components\Textarea::make('address')->label('Address')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone_number')->label('Phone Number')
                        ->numeric()->maxLength(10),

                    Forms\Components\TextInput::make('email_address')->label('Email Address')
                        ->unique()->email(),

                    // Class and Enrollment Information
                    Forms\Components\Select::make('class_id')
                        ->relationship('class', 'class_name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $class = \App\Models\Classes::find($state);
                            if ($class) {
                                $set('grade_level', $class->grade_level);
                            }else {
                                $set('grade_level', null);
                            }
                        }),
                    Forms\Components\TextInput::make('grade_level')
                        ->label('Tingkat Kelas')
                        ->disabled()
                        ->dehydrated(true) // <--- Biar tetap ikut ke database meskipun disabled
                        ->required()
                        ->rule('integer|min:1|max:6'), 
                    Forms\Components\DatePicker::make('admission_date')->label('Admission Date')->native(false)->default(today())
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                            'Graduated' => 'Graduated',
                        ])->native(false)
                        ->required(),

                    // Emergency Contact
                    Forms\Components\TextInput::make('emergency_contact_name')->label('Emergency Contact Name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('emergency_contact_number')->label('Emergency Contact Number')
                        ->numeric()->maxLength(10),

                    // Medical Information (Optional)
                    Forms\Components\TextArea::make('medical_conditions')->label('Medical Conditions')
                        ->nullable(),
                ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}

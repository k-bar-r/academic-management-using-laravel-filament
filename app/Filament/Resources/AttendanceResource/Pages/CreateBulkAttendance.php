<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Student;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;

class CreateBulkAttendance extends Page
{
    protected static string $resource = AttendanceResource::class;
    protected static string $view = 'filament.resources.attendance-resource.pages.create-bulk-attendance';
    protected static ?string $title = 'Create Bulk Attendance';
    
    public $class_id;
    public $date;
    public $defaultStatus = 'hadir';
    public $students = [];
    public $statuses = [];

    public function mount()
    {
        $this->form->fill();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Attendance')
                ->action('save')
                ->disabled(fn () => empty($this->students)),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('class_id')
                ->label('Class')
                ->options(Classes::all()->pluck('class_name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadStudents()),
                
            DatePicker::make('date')
                ->label('Attendance Date')
                ->default(now())
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadStudents()),
                
            Select::make('defaultStatus')
                ->label('Default Status')
                ->options([
                    'hadir' => 'Hadir',
                    'alpha' => 'Alpha',
                    'sakit' => 'Sakit',
                    'izin' => 'Izin',
                ])
                ->default('hadir')
                ->reactive()
                ->afterStateUpdated(fn () => $this->resetStatuses()),
        ];
    }

    public function loadStudents()
    {
        if (!$this->class_id || !$this->date) {
            $this->students = [];
            $this->statuses = [];
            return;
        }

        $this->students = Student::where('class_id', $this->class_id)->get();
        
        // Check for existing attendance records
        $existingAttendance = Attendance::where('class_id', $this->class_id)
            ->whereDate('date', $this->date)
            ->get()
            ->keyBy('student_id');
            
        // Initialize statuses array with existing values or default
        $this->statuses = [];
        foreach ($this->students as $student) {
            if (isset($existingAttendance[$student->id])) {
                $this->statuses[$student->id] = $existingAttendance[$student->id]->status;
            } else {
                $this->statuses[$student->id] = $this->defaultStatus;
            }
        }
    }
    
    public function resetStatuses()
    {
        foreach ($this->students as $student) {
            $this->statuses[$student->id] = $this->defaultStatus;
        }
    }

    public function save()
    {
        $this->validate([
            'class_id' => 'required',
            'date' => 'required|date',
        ]);

        $saved = 0;
        $date = Carbon::parse($this->date);
        
        foreach ($this->students as $student) {
            // Create or update attendance record
            Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'class_id' => $this->class_id,
                    'date' => $date->format('Y-m-d'),
                ],
                [
                    'status' => $this->statuses[$student->id],
                ]
            );
            $saved++;
        }

        Notification::make()
            ->title("Attendance saved for {$saved} students")
            ->success()
            ->send();
            
        return redirect()->route('filament.admin.resources.attendances.index');
    }
}
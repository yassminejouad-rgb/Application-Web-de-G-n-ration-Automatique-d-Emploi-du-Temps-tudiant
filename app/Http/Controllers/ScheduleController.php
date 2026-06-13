<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Schedule, Group, Teacher, Subject, Student};
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function dashboard() {
        $stats = [
            'students_count' => Student::count(),
            'teachers_count' => Teacher::count(),
            'classes_count'  => Group::count(),
        ];
        
        return view('dashboard', compact('stats'));
    }

    public function create() {
        $groups = Group::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        
        return view('schedule.create', compact('groups', 'teachers', 'subjects'));
    }
    
    public function timetable() {
        $groups = Group::all();
        $schedules = Schedule::with(['group', 'teacher', 'subject'])->orderBy('start_time')->get();
        $groupedSchedules = $schedules->groupBy('group_id');
        return view('schedule.timetable', compact('groupedSchedules', 'groups'));
    }

    public function store(Request $request) {
        $request->validate([
            'group_id' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $teacherConflict = Schedule::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        $groupConflict = Schedule::where('group_id', $request->group_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        if ($teacherConflict) {
            return back()->with('error', 'Conflit détecté : Le professeur est occupé à ce moment-là !');
        }
        if ($groupConflict) {
            return back()->with('error', 'Conflit détecté : La classe a un autre cours en même temps !');
        }

        Schedule::create($request->all());
        return redirect()->route('schedule.timetable')->with('success', 'La séance a été ajoutée avec succès !');
    }

    public function autoGenerate() {
        $groups = Group::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $times = [['09:30', '11:30'], ['11:45', '13:45'], ['14:30', '16:30'], ['16:45', '18:45']];

        foreach ($groups as $group) {
            $teachers = Teacher::inRandomOrder()->get();
            $teacherIndex = 0;
            
            foreach ($days as $day) {
                foreach ($times as $time) {
                    if(!isset($teachers[$teacherIndex])) {
                        $teacherIndex = 0;
                        $teachers = Teacher::inRandomOrder()->get();
                    }
                    $teacher = $teachers[$teacherIndex];
                    
                    $conflict = Schedule::where('teacher_id', $teacher->id)
                                ->where('day_of_week', $day)
                                ->where(function($q) use ($time) {
                                     $q->where('start_time', '<=', $time[0])
                                       ->where('end_time', '>', $time[0]);
                                })->exists();
                        
                    $groupConflict = Schedule::where('group_id', $group->id)
                                ->where('day_of_week', $day)
                                ->where(function($q) use ($time) {
                                     $q->where('start_time', '<=', $time[0])
                                       ->where('end_time', '>', $time[0]);
                                })->exists();

                    if (!$conflict && !$groupConflict) {
                        Schedule::firstOrCreate([
                            'group_id' => $group->id,
                            'teacher_id' => $teacher->id,
                            'subject_id' => $teacher->subject_id,
                            'day_of_week' => $day,
                            'start_time' => $time[0],
                            'end_time' => $time[1],
                        ]);
                    }
                    $teacherIndex++;
                }
            }
        }
        return redirect()->route('schedule.timetable')->with('success', 'L\'emploi du temps de la semaine a été généré automatiquement avec succès ! 🤖');
    }

    public function clear() {
        Schedule::truncate();
        return redirect()->route('schedule.timetable')->with('success', 'L\'emploi du temps a été entièrement vidé avec succès ! 🗑️');
    }
}


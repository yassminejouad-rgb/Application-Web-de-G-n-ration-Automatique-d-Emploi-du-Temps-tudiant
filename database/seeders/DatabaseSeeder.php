<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 0. Create Admin User
        User::create([
            'first_name' => 'Directeur',
            'last_name' => 'EPG',
            'email' => 'admin@epg.ma',
            'password' => Hash::make('12345678'),
        ]);

        // 1. Create Groups
        $group1 = Group::create(['name' => 'Technicien Spécialisé 2ème année']);
        $group2 = Group::create(['name' => 'Technicien Supérieur 1ère année']);

        // 2. Create Subjects
        $progClient = Subject::create(['name' => 'Programmation Client-Serveur']);
        $appHyper = Subject::create(['name' => 'Applications hypermédias']);
        $bdd = Subject::create(['name' => 'Systèmes de base données II']);
        $uxui = Subject::create(['name' => 'UX/UI']);
        $analyse = Subject::create(['name' => 'Analyse et Conception']);
        $webDynamique = Subject::create(['name' => 'Programmation de sites Web dynamiques']);

        // 3. Create Teachers
        Teacher::create(['name' => 'M. Alaoui', 'subject_id' => $progClient->id]);
        Teacher::create(['name' => 'Mme. Bennis', 'subject_id' => $appHyper->id]);
        Teacher::create(['name' => 'M. Idrissi', 'subject_id' => $bdd->id]);
        Teacher::create(['name' => 'Mme. Tazi', 'subject_id' => $uxui->id]);
        Teacher::create(['name' => 'M. Chraibi', 'subject_id' => $analyse->id]);
        Teacher::create(['name' => 'M. Bennani', 'subject_id' => $webDynamique->id]);

        // 4. Create dummy students for stats
        for($i=1; $i<=25; $i++){
            Student::create(['name' => 'Stagiaire EPG ' . $i, 'group_id' => $group1->id]);
        }
        for($i=26; $i<=45; $i++){
            Student::create(['name' => 'Stagiaire EPG ' . $i, 'group_id' => $group2->id]);
        }
    }
}

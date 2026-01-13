<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class UpdateStudentAdmissionNo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-student-admission-no';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate admission numbers for students with NULL admission_no';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update students with NULL admission_no
        $prefix = date('Y');
        
        DB::statement(
            "UPDATE students 
             SET admission_no = CONCAT(?, '-', LPAD(id, 4, '0')) 
             WHERE admission_no IS NULL",
            [$prefix]
        );

        $count = Student::whereNull('admission_no')->count();
        
        if ($count === 0) {
            $this->info('✓ All students now have admission numbers!');
        } else {
            $this->error('Some students still have NULL admission_no. Please check the database.');
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ClassType;
use Database\Seeders\ClassTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstructorTest extends TestCase
    
    {
        use RefreshDatabase;

        public function test_instructor_is_redirected_to_instructor_dashboard() {
            $user = User::factory()->create([
                'role' => 'instructor'
            ]);
    
            $response = $this->actingAs($user)
            ->get('/dashboard');
    
            $response->assertRedirectToRoute('instructor.dashboard');
    
            $this->followRedirects($response)->assertSeeText("Hey Instructor");
        }
    
        public function test_instructor_can_schedule_a_class() {
            //Given
            $user = User::factory()->create([
                'role' => 'instructor'
            ]);
            $this->seed(ClassTypeSeeder::class);
    
            //When
            $response = $this->actingAs($user)
                ->post('instructor/schedule', [
                'class_type_id' => ClassType::first()->id,
                'date' => '2023-04-20',
                'time' => '09:00:00'
            ]);
            
            //Then 
            
            $this->assertDatabaseHas('scheduled_classes', [
                'class_type_id' => ClassType::first()->id,
                'date_time' => '2023-04-20 09:00:00',
            ]);

            $response->assertRedirectToRoute('schedule.index');
        }

        public function test_instructor_can_cancel_class() {
            // Given
            $user = User::factory()->create([
                'role' => 'instructor'
            ]);
            $this->seed(ClassTypeSeeder::class);
            $scheduledClass = ScheduledClass::create([
                'instructor_id' => $user->id,
                'class_type_id' => ClassType::first()->id,
                'date_time' => '2023-04-20 10:00:00'
            ]);
    
            // When
            $response = $this->actingAs($user)
                ->delete('/instructor/schedule/'.$scheduledClass->id);
    
            // Then
            $this->assertDatabaseMissing('scheduled_classes',[
                'id' => $scheduledClass->id
            ]);
        }
}

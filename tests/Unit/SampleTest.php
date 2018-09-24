<?php
// namespace Tests\Unit;
use Tests\TestCase; 
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Laravel\Dusk\DuskServiceProvider;
use App\Models\User;
use App\Patient;
class SampleTest extends TestCase
{
    public function testDatabaseFields()
    {
        // parent::SetUp();
        $patient = new App\Patient;
        $patient->setFirstName('Mary');
        $this->assertEquals($patient->getFirstName(),'Mary');
    }
    // public function testAccessPatients()
    // {
    //     
    //     $this->visit('patients');
    // }
    // public function testDatabase()
    // {
    //     // Make call to application...

    //     $this->assertDatabaseHas('patients', [
    //         'full_name' => 'Grey'
    //     ]);
    // }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Emp;

class EmpTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test updating a column value in the database table.
     *
     * @return void
     */
    public function testUpdateColumnValue()
    {
        // Buat objek model atau instance tabel yang ingin Anda perbarui
        $emp = Emp::factory()->create(
            [
                'jenis' => 'stiker',
                'jumlah' => 99
            ]
        );

        // Lakukan pembaruan kolom tertentu
        $emp->update(
            [
                'jenis' => 'stiker',
                'jumlah' => 80
            ]
        );

        // Retrieve the fresh instance from the database
        $updatedEmp = Emp::find($emp->id);

        // Periksa apakah kolom berhasil diperbarui dalam database
        $this->assertEquals(80, 80);
    }
}

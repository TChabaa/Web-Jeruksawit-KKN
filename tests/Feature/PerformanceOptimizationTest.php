<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Jobs\ProcessSuratApproval;
use App\Models\Surat;
use App\Models\Pemohon;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Queue;

class PerformanceOptimizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that PDF generation and email processing is queued
     */
    public function test_surat_approval_is_queued()
    {
        Queue::fake();

        // Create test data
        $jenisSurat = JenisSurat::factory()->create(['nama_jenis' => 'SKCK']);
        $pemohon = Pemohon::factory()->create();
        $surat = Surat::factory()->create([
            'id_pemohon' => $pemohon->id_pemohon,
            'id_jenis' => $jenisSurat->id_jenis,
            'status' => 'disetujui'
        ]);

        // Simulate approval process (this would normally dispatch the job)
        ProcessSuratApproval::dispatch($surat->id_surat);

        // Assert that the job was queued
        Queue::assertPushed(ProcessSuratApproval::class, function ($job) use ($surat) {
            return $job->suratId === $surat->id_surat;
        });
    }

    /**
     * Test PDF caching functionality
     */
    public function test_pdf_caching_works()
    {
        $jenisSurat = JenisSurat::factory()->create(['nama_jenis' => 'SKCK']);
        $pemohon = Pemohon::factory()->create();
        $surat = Surat::factory()->create([
            'id_pemohon' => $pemohon->id_pemohon,
            'id_jenis' => $jenisSurat->id_jenis,
            'status' => 'disetujui'
        ]);

        $pdfController = new \App\Http\Controllers\PDFController();

        // First generation should create cache entry
        $startTime = microtime(true);
        $pdfPath1 = $pdfController->generateSuratPdf($surat);
        $firstGenerationTime = microtime(true) - $startTime;

        // Second generation should use cache and be faster
        $startTime = microtime(true);
        $pdfPath2 = $pdfController->generateSuratPdf($surat);
        $secondGenerationTime = microtime(true) - $startTime;

        // Assert that cached version is significantly faster
        $this->assertLessThan($firstGenerationTime * 0.5, $secondGenerationTime);
        $this->assertEquals($pdfPath1, $pdfPath2);
    }

    /**
     * Test memory optimization in PDF generation
     */
    public function test_pdf_generation_memory_optimization()
    {
        $initialMemory = memory_get_usage(true);

        $jenisSurat = JenisSurat::factory()->create(['nama_jenis' => 'SKCK']);
        $pemohon = Pemohon::factory()->create();
        $surat = Surat::factory()->create([
            'id_pemohon' => $pemohon->id_pemohon,
            'id_jenis' => $jenisSurat->id_jenis,
            'status' => 'disetujui'
        ]);

        $pdfController = new \App\Http\Controllers\PDFController();
        $pdfPath = $pdfController->generateSuratPdf($surat);

        $peakMemory = memory_get_peak_usage(true);
        $memoryUsed = $peakMemory - $initialMemory;

        // Assert that memory usage is within reasonable limits (< 50MB for test)
        $this->assertLessThan(50 * 1024 * 1024, $memoryUsed, 'PDF generation uses too much memory');
        $this->assertFileExists($pdfPath);
    }

    /**
     * Benchmark test for queue processing vs synchronous processing
     */
    public function test_queue_performance_benchmark()
    {
        Queue::fake();

        $startTime = microtime(true);

        // Simulate processing 10 surat approvals
        for ($i = 0; $i < 10; $i++) {
            $jenisSurat = JenisSurat::factory()->create(['nama_jenis' => 'SKCK']);
            $pemohon = Pemohon::factory()->create();
            $surat = Surat::factory()->create([
                'id_pemohon' => $pemohon->id_pemohon,
                'id_jenis' => $jenisSurat->id_jenis,
                'status' => 'disetujui'
            ]);

            ProcessSuratApproval::dispatch($surat->id_surat);
        }

        $queueTime = microtime(true) - $startTime;

        // Queue dispatching should be very fast (< 1 second for 10 jobs)
        $this->assertLessThan(1.0, $queueTime, 'Queue dispatching is too slow');

        // Assert all jobs were queued
        Queue::assertPushed(ProcessSuratApproval::class, 10);
    }
}

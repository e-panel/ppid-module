<?php

Route::prefix('epanel/plugin')->as('epanel.')->middleware(['auth', 'check.permission:PPID'])->group(function() 
{
    Route::resources([
        'unduhan' => 'Unduhan\\KategoriController',
        'unduhan.file' => 'Unduhan\\FileController',
        
        'pengadaan' => 'Plugin\\PengadaanController',
        'sop' => 'Plugin\\SOPController',
        'layanan' => 'Plugin\\LayananController',
    ]);
});
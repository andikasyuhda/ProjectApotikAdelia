<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Running migrations...\n";
$status = $kernel->call('migrate', [
    '--force' => true,
]);

echo "Migration completed with status: " . $status . "\n";

// Seed sample data
echo "Seeding sample medicine data...\n";

$medicines = [
    ['nama_obat' => 'Paracetamol 500mg', 'stok' => 150, 'lokasi' => 'Rak A1 - Lantai 1'],
    ['nama_obat' => 'Amoxicillin 500mg', 'stok' => 75, 'lokasi' => 'Rak A2 - Lantai 1'],
    ['nama_obat' => 'Ibuprofen 400mg', 'stok' => 30, 'lokasi' => 'Rak B1 - Lantai 1'],
    ['nama_obat' => 'Vitamin C 1000mg', 'stok' => 200, 'lokasi' => 'Rak C1 - Lantai 2'],
    ['nama_obat' => 'Cetirizine 10mg', 'stok' => 45, 'lokasi' => 'Rak B2 - Lantai 1'],
];

foreach ($medicines as $medicine) {
    \App\Models\Medicine::create($medicine);
}

echo "Sample data seeded successfully!\n";

$kernel->terminate(new Symfony\Component\Console\Input\ArrayInput([]), $status);

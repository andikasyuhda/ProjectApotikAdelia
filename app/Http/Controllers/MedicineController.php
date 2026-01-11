<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display the dashboard
     */
    public function dashboard()
    {
        $totalJenisObat = Medicine::count();
        $totalStok = Medicine::sum('stok');
        $stokRendah = Medicine::where('stok', '<', 50)->count();
        
        // Get recent medicines
        $recentMedicines = Medicine::orderBy('created_at', 'desc')->take(5)->get();
        
        // Get low stock medicines
        $lowStockMedicines = Medicine::where('stok', '<', 50)->get();
        
        return view('dashboard', compact('totalJenisObat', 'totalStok', 'stokRendah', 'recentMedicines', 'lowStockMedicines'));
    }

    /**
     * Display the medicine list
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $medicines = Medicine::search($search)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('medicines.index', compact('medicines', 'search'));
    }

    /**
     * Show the form for creating a new medicine
     */
    public function create()
    {
        return view('medicines.create');
    }

    /**
     * Store a newly created medicine
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    /**
     * Update the specified medicine
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil diperbarui!');
    }

    /**
     * Remove the specified medicine
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Obat berhasil dihapus!');
    }
}

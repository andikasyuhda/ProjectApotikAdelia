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
        $status = $request->get('status');
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        // Validate sort column
        $allowedSorts = ['nama_obat', 'stok', 'lokasi', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        
        $query = Medicine::search($search);
        
        // Apply status filter based on stock levels
        if ($status === 'aman') {
            $query->where('stok', '>', 100);
        } elseif ($status === 'sedang') {
            $query->whereBetween('stok', [50, 100]);
        } elseif ($status === 'rendah') {
            $query->where('stok', '<', 50);
        }
        
        $medicines = $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc')
            ->paginate(15)
            ->withQueryString();
        
        // Get total count for "Semua" badge
        $totalCount = Medicine::search($search)->count();
        
        return view('medicines.index', compact('medicines', 'search', 'totalCount'));
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

    /**
     * Adjust stock for a medicine and record history
     */
    public function adjustStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'change_amount' => 'required|integer',
            'change_type' => 'required|in:in,out,adjust',
            'notes' => 'nullable|string|max:255',
        ]);

        $previousStock = $medicine->stok;
        $changeAmount = $validated['change_amount'];
        
        // Calculate new stock based on change type
        if ($validated['change_type'] === 'in') {
            $newStock = $previousStock + abs($changeAmount);
        } elseif ($validated['change_type'] === 'out') {
            $newStock = max(0, $previousStock - abs($changeAmount));
        } else {
            $newStock = $changeAmount; // Direct adjustment
        }

        // Update medicine stock
        $medicine->update(['stok' => $newStock]);

        // Record history
        \App\Models\StockHistory::create([
            'medicine_id' => $medicine->id,
            'user_id' => auth()->id(),
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'change_amount' => $newStock - $previousStock,
            'change_type' => $validated['change_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $typeLabels = ['in' => 'ditambah', 'out' => 'dikurangi', 'adjust' => 'disesuaikan'];
        
        return redirect()->route('medicines.index')
            ->with('success', "Stok {$medicine->nama_obat} berhasil {$typeLabels[$validated['change_type']]}!");
    }

    /**
     * Show stock history for a medicine
     */
    public function history(Medicine $medicine)
    {
        $histories = $medicine->stockHistories()->with('user')->paginate(20);
        
        return view('medicines.history', compact('medicine', 'histories'));
    }

    /**
     * Search suggestions for autocomplete
     */
    public function suggest(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $medicines = Medicine::where('nama_obat', 'like', "%{$query}%")
            ->select('id', 'nama_obat', 'stok')
            ->take(8)
            ->get();

        return response()->json($medicines);
    }
}

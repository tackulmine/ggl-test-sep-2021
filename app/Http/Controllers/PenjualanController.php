<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\User;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Libraries\FormFields;
use App\Http\Requests\PenjualanCreateRequest;
use App\Http\Requests\PenjualanUpdateRequest;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualans = Penjualan::with('user','details')->latest()->get();

        return view('penjualan.index', compact('penjualans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Penjualan $penjualan)
    {
        $formFields = new FormFields($penjualan);
        $formFields = $formFields->generateForm();

        $data = [
            'penjualan' => $formFields,
            'users' => User::where('id', '<>', 1)->pluck('name', 'id'),
            'barangs' => Barang::pluck('nama_barang', 'id'),
        ];
        // dd($data);

        return view('penjualan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenjualanCreateRequest $request)
    {
        $attributes = $request->all();

        \DB::beginTransaction();
        try {
            if ($penjualan = Penjualan::create($attributes)) {
                foreach ($request->id_barang as $index => $idBarang) {
                    // check if stok barang is available
                    $barang = Barang::findOrFail($idBarang);
                    $stok = $barang->stok;
                    if ($stok < $request->input('total_barang')[$index]) {
                        \DB::rollback();
                        return back()
                            ->withErrors(["Jumlah Barang '{$barang->nama_barang}' maksimal {$stok}!"])
                            ->withInput();
                    }
                    $detail = $penjualan->details()->create([
                        'id_barang' => $idBarang,
                        'total_barang' => $request->input('total_barang')[$index],
                    ]);

                    if ($detail) {
                        $detail->barang->stoks()->create([
                            'total_barang' => $detail->total_barang,
                            'jenis_stok' => 'out',
                            'reference_table' => 'penjualan_details',
                            'reference_id' => $detail->id,
                        ]);
                    }
                }
            }

            \DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with('status', "New Penjualan '#{$penjualan->id}' has been created successfully!");
        } catch (\Throwable $th) {
            \DB::rollback();
            //throw $th;
            return back()
                ->withErrors([$th->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    // public function show(Penjualan $penjualan)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        $penjualan->load('details');
        $formFields = new FormFields($penjualan);
        $formFields = $formFields->generateForm();

        $formFields->details = $penjualan->details;

        $data = [
            'penjualan' => $formFields,
            'users' => User::where('id', '<>', 1)->pluck('name', 'id'),
            'barangs' => Barang::pluck('nama_barang', 'id'),
        ];

        return view('penjualan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(PenjualanUpdateRequest $request, Penjualan $penjualan)
    {
        $attributes = $request->all();

        \DB::beginTransaction();
        try {
            if ($penjualan->update($attributes)) {
                // old details
                if ($request->has('old_total_barang')) {
                    foreach ($request->old_total_barang as $oldId => $oldTotalBarang) {
                        $detail = $penjualan->details()->where('id', $oldId)->firstOrFail();
                        // delete detail if empty stok
                        if ($request->input('old_total_barang')[$oldId] == 0) {
                            $deleteStok = $detail->barang->stoks()->where([
                                'reference_table' => 'penjualan_details',
                                'reference_id' => $detail->id,
                                'jenis_stok' => 'out',
                            ])->delete();

                            if ($deleteStok) {
                                $detail->delete();
                            }
                        }

                        // check if stok barang is available
                        $barang = Barang::findOrFail($detail->id_barang);
                        $stok = $barang->stok;
                        $stokTotal = $stok + $detail->total_barang;
                        if ($stok < ($oldTotalBarang - $detail->total_barang)) {
                            \DB::rollback();
                            return back()
                                ->withErrors(["Gagal update!! Jumlah Barang '{$barang->nama_barang}' maksimal {$stokTotal}!"])
                                ->withInput();
                        }

                        // update
                        $detailUpdated = $detail->update([
                            'total_barang' => $oldTotalBarang,
                        ]);
                        if ($detailUpdated) {
                            Stok::where([
                                    'reference_table' => 'penjualan_details',
                                    'reference_id' => $detail->id,
                                    'jenis_stok' => 'out',
                                ])->update([
                                    'total_barang' => $detail->total_barang,
                                ]);
                        }
                    }
                }

                // new details
                if ($request->has('id_barang')) {
                    foreach ($request->id_barang as $index => $idBarang) {
                        // if barang is exist on details? updated!
                        if ($penjualan->details()->where('id_barang', $idBarang)->exists()) {
                            // get detail
                            $detail = $penjualan->details()->where('id_barang', $idBarang)->first();

                            // check if stok barang is available
                            $barang = Barang::findOrFail($idBarang);
                            $stok = $barang->stok;
                            if ($stok < $request->input('total_barang')[$index]) {
                                \DB::rollback();
                                return back()
                                    ->withErrors(["Gagal menambahkan barang baru!! Jumlah Barang '{$barang->nama_barang}' maksimal {$stok}!"])
                                    ->withInput();
                            }

                            // update
                            $newTotalBarang = $detail->total_barang + $request->input('total_barang')[$index];
                            $detailUpdated = $detail->update([
                                'total_barang' => $newTotalBarang,
                            ]);
                            if ($detailUpdated) {
                                Stok::where([
                                        'reference_table' => 'penjualan_details',
                                        'reference_id' => $detail->id,
                                        'jenis_stok' => 'out',
                                    ])->update([
                                        'total_barang' => $detail->total_barang,
                                    ]);
                            }
                        } else {
                            // check if stok barang is available
                            $barang = Barang::findOrFail($idBarang);
                            $stok = $barang->stok;
                            if ($stok < $request->input('total_barang')[$index]) {
                                \DB::rollback();
                                return back()
                                    ->withErrors(["Gagal menambahkan barang baru!! Jumlah Barang '{$barang->nama_barang}' maksimal {$stok}!"])
                                    ->withInput();
                            }

                            // create
                            $detail = $penjualan->details()->create([
                                'id_barang' => $idBarang,
                                'total_barang' => $request->input('total_barang')[$index],
                            ]);
                            if ($detail) {
                                $detail->barang->stoks()->create([
                                    'total_barang' => $detail->total_barang,
                                    'jenis_stok' => 'out',
                                    'reference_table' => 'penjualan_details',
                                    'reference_id' => $detail->id,
                                ]);
                            }
                        }
                    }
                }
            }

            \DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with('status', "Penjualan '#{$penjualan->id}' has been updated successfully!");
        } catch (\Throwable $th) {
            \DB::rollback();
            //throw $th;
            return back()
                ->withErrors([$th->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        $title = $penjualan->id;

        \DB::beginTransaction();
        try {
            // delete stoks
            foreach ($penjualan->details as $detail) {
                Stok::where([
                    'reference_table' => 'penjualan_details',
                    'reference_id' => $detail->id,
                ])->delete();
            }
            // delete penjualan details & penjualan
            if ($penjualan->details()->delete()) {
                $penjualan->delete();
            }
            \DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with('status', "Penjualan '#{$title}' has been deleted successfully!");
        } catch (\Throwable $th) {
            \DB::rollback();
            //throw $th;
            return back()
                ->withErrors([$th->getMessage()])
                ->withInput();
        }
    }
}

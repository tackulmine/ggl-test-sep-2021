<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Libraries\FormFields;
use App\Http\Requests\BarangCreateRequest;
use App\Http\Requests\BarangUpdateRequest;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangs = Barang::with('stoks')->latest()->get();

        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Barang $barang)
    {
        $formFields = new FormFields($barang);
        $formFields = $formFields->generateForm();

        $data = [
            'barang' => $formFields,
        ];

        return view('barang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarangCreateRequest $request)
    {
        $attributes = $request->all();

        if ($barang = Barang::create($attributes)) {
            if ($request->hasFile('gambar_barang')) {
                $path = $request->file('gambar_barang')->storeAs(
                    'barang',
                    $barang->id.'.'.strtolower($request->file('gambar_barang')->extension()),
                    'shared'
                );

                $barang->update([
                    'gambar_barang' => $path,
                ]);
            }

            return redirect()
                ->route('barang.index')
                ->with('status', "New Barang '{$barang->nama_barang}' has been created successfully!");
        }

        return back()
            ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    // public function show(Barang $barang)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        $formFields = new FormFields($barang);
        $formFields = $formFields->generateForm();

        $data = [
            'barang' => $formFields,
        ];

        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(BarangUpdateRequest $request, Barang $barang)
    {
        $attributes = $request->all();

        if ($request->hasFile('gambar_barang')) {
            $path = $request->file('gambar_barang')->storeAs(
                'barang',
                $barang->id.'.'.strtolower($request->file('gambar_barang')->extension()),
                'shared'
            );

            $attributes = [
                'gambar_barang' => $path,
            ] + $attributes;
        }

        if ($barang->update($attributes)) {
            return redirect()
                ->route('barang.index')
                ->with('status', "Barang '{$barang->nama_barang}' has been updated successfully!");
        }

        return back()
            ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $title = $barang->nama_barang;

        if ($barang->delete()) {
            return redirect()
                ->route('barang.index')
                ->with('status', "Barang '{$title}' has been deleted successfully!");
        }

        return back()
            ->withInput();
    }

    public function editStok(Barang $barang)
    {
        $formFields = new FormFields($barang);
        $formFields = $formFields->generateForm();

        $data = [
            'barang' => $formFields,
        ];

        return view('barang.edit-stok', compact('barang'));
    }

    public function updateStok(Request $request, Barang $barang)
    {
        $attributes = $request->all();

        if ($barang->stoks()->create($attributes)) {
            return redirect()
                ->route('barang.index')
                ->with('status', "Stok Barang '{$barang->nama_barang}' has been updated successfully!");
        }

        return back()
            ->withInput();
    }
}

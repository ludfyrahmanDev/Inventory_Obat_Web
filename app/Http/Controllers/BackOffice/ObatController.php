<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\Supplier;

/**
 * model block
 */
class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Obat::get();
        $title = 'List Data Obat';
        return view('pages.backoffice.obat.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Tambah Data Obat';
        $data = (object)[
            'name'              => '',
            'supplier_id'       => '',
            'type'              => 'create',
        ];
        $supplier = Supplier::get();
        return view('pages.backoffice.obat.form', compact('title', 'data', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'supplier_id' => 'required',
        ]);

        try {
            Obat::create([
                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
            ]);
            return redirect('obat')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Obat::where('id', $id)->first();
        $title = 'Detail Data Obat';
        $data->type = 'detail';

        return view('pages.backoffice.obat.form', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Obat::where('id', $id)->first();
        $title = 'Edit Data Obat';
        $data->type = 'edit';
        $supplier = Supplier::get();
        return view('pages.backoffice.obat.form', compact('data', 'title', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'supplier_id' => 'required',
        ]);
        try {
            $data = ([
                'name' => $request->name,
                'supplier_id' => $request->supplier_id,
            ]);

            Obat::where('id', $id)->update($data);
            return redirect('obat')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Obat::find($id)->delete();
        return redirect('obat')->with('success', 'Berhasil mengubah data!');
    }
}

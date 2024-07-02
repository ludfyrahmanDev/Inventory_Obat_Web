<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

/**
 * model block
 */
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Supplier::all();
        $title = 'List Data Supplier';
        return view('pages.backoffice.supplier.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Tambah Data Supplier';
        $data = (object)[
            'name'              => '',
            'alias'             => '',
            'address'           => '',
            'phone'             => '',
            'type'              => 'create',
        ];
        return view('pages.backoffice.supplier.form', compact('title', 'data'));
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
            'address' => 'required',
            'phone' => 'required',
        ]);

        try {
            Supplier::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);
            return redirect('supplier')->with('success', 'Berhasil menambah data!');
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
        $data = Category::where('id', $id)->first();
        $title = 'Detail Data Supplier';
        $data->type = 'detail';

        return view('pages.backoffice.supplier.form', compact('data', 'title'));
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
        $data = Supplier::find($id);
        $title = 'Edit Data Supplier';
        $data->type = 'edit';
        return view('pages.backoffice.supplier.form', compact('data', 'title'));
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
            'address' => 'required',
            'phone' => 'required',
        ]);
        try {
            $supplier = Supplier::find($id);
            $supplier->name = $request->name;
            $supplier->alias = $request->alias;
            $supplier->address = $request->address;
            $supplier->phone = $request->phone;
            $supplier->save();
            return redirect('supplier')->with('success', 'Berhasil mengubah data!');
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
        Supplier::find($id)->delete();
        return redirect('supplier')->with('success', 'Berhasil menghapus data!');
    }
}
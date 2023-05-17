<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quests = Soal::all();

        if (!$quests) return response([
            'success' => true,
            'message' => 'Data Not Found',
            'data' => ''
        ], 404);

        return response([
            'success' => true,
            'message' => 'List Semua Soal',
            'data' => $quests
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'qtitle' => 'required|string',
            'kd' => 'required|integer',
            'question' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'success'=> true,
                'message' => 'Error Validation',
                'data' => $validator->errors()
            ], 400);
        }

        $data = Soal::create([
            'qtitle' => $input['qtitle'],
            'kd' => $input['kd'],
            'question' => $input['question'],
        ]);

        return response([
            'success'=> true,
            'message' =>'Soal Berhasil Ditambahkan',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function show($kd)
    {
        $quest = Soal::where('kd', $kd)->first();
        if (!$quest) return response([
            'success' => true,
            'message' => 'Data Not Found',
            'data' => ''
        ], 404);

        return response([
            'success' => true,
            'message' => 'Soal ditemukan',
            'data' => $quest
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit(Soal $soal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quest = Soal::where('id', $id)->first();
        if (!$quest) return response([
            'success' => true,
            'message' => 'Data not found',
            'data' => ''
        ], 404);

        $quest->delete();

        return response([
            'success'=> true,
            'message' => 'Soal Berhasil Dihapus',
        ], 201);
    }
}

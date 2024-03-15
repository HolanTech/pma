<?php

namespace App\Http\Controllers;

use App\Models\DataOtb;
use Illuminate\Http\Request;

class DataOtbController extends Controller
{
    public function site()
    {
        $datas = DataOtb::all();
        return view('data_otb.site', compact('datas'));
    }
    public function index(Request $request)
    {
        $site1 = $request->query('site1');
        $site2 = $request->query('site2');

        // Contoh pencarian data, sesuaikan dengan struktur database Anda
        $dataOtb = null;
        if ($site1 && $site2) {
            $dataOtb = DataOtb::where('site1', $site1)->where('site2', $site2)->first();
        }

        if ($dataOtb) {
            // Jika data ditemukan
            $jsonData = $dataOtb->data ?: json_encode([[]]);
            $jsonMergeCells = $dataOtb->merge_cells ?: json_encode([]);
        } else {
            // Jika tidak ditemukan, siapkan Handsontable dengan template default dan konfigurasi merge cells
            $jsonData = json_encode([
                ["SITE", "", "<>", "SITE", "", "JARAK", "JUMLAH SPLICE", "TOTAL LOSS", "AVERAGE LOSS", ""],
                ["", "", "", "", "", "", "", "dB", "dB/Km", ""],
                ["Tube", "No", "CORE", "Direction", "", "CUSTOMER", "Distance (km)", "Commulate Loss", "Remark", ""],
                ["", "", "", "OTB FAR END", "STATUS CORE", "", "", "", "", ""],
                // Tambahkan lebih banyak baris kosong sesuai kebutuhan
            ]);
            $jsonMergeCells = json_encode([
                // Konfigurasi merge cells sesuai permintaan
                ["row" => 2, "col" => 0, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 1, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 2, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 3, "rowspan" => 1, "colspan" => 2],
                ["row" => 2, "col" => 5, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 6, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 7, "rowspan" => 2, "colspan" => 1],
                ["row" => 2, "col" => 8, "rowspan" => 2, "colspan" => 1],
                ["row" => 4, "col" => 0, "rowspan" => 6, "colspan" => 1],
                ["row" => 10, "col" => 0, "rowspan" => 6, "colspan" => 1],
                ["row" => 0, "col" => 0, "rowspan" => 1, "colspan" => 2],
                ["row" => 0, "col" => 3, "rowspan" => 1, "colspan" => 2],
                // Tambahkan konfigurasi merge cells lainnya sesuai kebutuhan
            ]);
        }

        return view('data_otb.index', compact('jsonData', 'jsonMergeCells', 'site1', 'site2'));
    }





    public function showMap(Request $request)
    {
        $site1 = $request->query('site1');
        $site2 = $request->query('site2');

        $dataOtb = DataOtb::where('site1', $site1)->where('site2', $site2)->first();

        $jsonData = $dataOtb ? json_decode($dataOtb->data, true) : [];
        $siteA = null;
        $siteB = null;

        if (!empty($jsonData) && count($jsonData) > 1) {
            $siteA = [
                'lat' => $jsonData[1][0],
                'lng' => $jsonData[1][1],
                'name' => $jsonData[0][0] // Mengambil nama SITE A dari JSON
            ];
            $siteB = [
                'lat' => $jsonData[1][3],
                'lng' => $jsonData[1][4],
                'name' => $jsonData[0][3] // Mengambil nama SITE B dari JSON
            ];
        }

        return view('data_otb.maps', compact('siteA', 'siteB'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'mergeCells' => 'nullable',
            'site1' => 'required',
            'site2' => 'required',
            // 'cellMeta' => 'required'
        ]);

        // Gunakan updateOrCreate untuk mengecek dan memutuskan apakah perlu update atau create
        // Kunci array pertama menentukan kondisi pencarian (kondisi "where")
        // Kunci array kedua menentukan nilai yang akan diupdate atau ditambahkan
        $dataOtb = DataOtb::updateOrCreate(
            [
                'site1' => $request->input('site1'),
                'site2' => $request->input('site2')
            ],
            [
                'data' => json_encode($request->input('data')),
                'merge_cells' => json_encode($request->input('mergeCells')),
                // 'cellMeta' => json_encode($request->input('cellMeta')),
            ]
        );

        return response()->json(['message' => 'Data berhasil disimpan']);
    }
}

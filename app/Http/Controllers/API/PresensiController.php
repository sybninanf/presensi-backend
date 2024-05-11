<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use stdClass;
date_default_timezone_set("Asia/Jakarta");

class PresensiController extends Controller
{
    function getPresensis()
    {
        $presensis = Presensi::where('user_id', Auth::user()->id)->get();
        foreach($presensis as $item) {
            if ($item->tanggal == date('Y-m-d')) {
                $item->is_hari_ini = true;
            } else {
                $item->is_hari_ini = false;
            }
            $datetime = Carbon::parse($item->tanggal)->locale('id');
            $masuk = Carbon::parse($item->masuk)->locale('id');
            $pulang = Carbon::parse($item->pulang)->locale('id');

            $datetime->settings(['formatFunction' => 'translatedFormat']);
            $masuk->settings(['formatFunction' => 'translatedFormat']);
            $pulang->settings(['formatFunction' => 'translatedFormat']);
            
            $item->tanggal = $datetime->format('l, j F Y');
            $item->masuk = $masuk->format('H:i');
            $item->pulang = $pulang->format('H:i');
        }

        return response()->json([
            'success' => true,
            'data' => $presensis,
            'message' => 'Sukses menampilkan data'
        ]);
        
    
    }
    function savePresensi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $keterangan = "";

        try {
            $presensi = Presensi::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('user_id', Auth::user()->id)
                ->first();

            if ($presensi == null) {
                $presensi = Presensi::create([
                    'user_id' => Auth::user()->id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'tanggal' => date('Y-m-d'),
                    'masuk' => now()->toTimeString(),
                ]);
            } else {
                $data = [
                    'pulang' => now()->toTimeString(),
                ];

                Presensi::whereDate('tanggal', '=', date('Y-m-d'))
                    ->where('user_id', Auth::user()->id)
                    ->update($data);
            }

            $presensi = Presensi::whereDate('tanggal', '=', date('Y-m-d'))
                ->where('user_id', Auth::user()->id)
                ->first();

            return response()->json([
                'success' => true,
                'data' => $presensi,
                'message' => 'Sukses simpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving presensi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

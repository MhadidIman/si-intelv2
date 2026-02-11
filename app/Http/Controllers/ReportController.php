<?php

namespace App\Http\Controllers;

use App\Models\Dpo;
use App\Models\Wna;
use App\Models\Ormas;
use App\Models\PamSdo;
use App\Models\Lapinhar;
use App\Models\JmsActivity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * LAPINHAR (Laporan Informasi Harian)
     */
    public function cetakLapinhar()
    {
        $data = Lapinhar::latest()->get();
        $pdf = Pdf::loadView('reports.lapinhar-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Lapinhar.pdf');
    }

    public function cetakLapinharSatuan($id)
    {
        $item = Lapinhar::findOrFail($id);
        $pdf = Pdf::loadView('reports.lapinhar-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Informasi-' . $id . '.pdf');
    }

    /**
     * DPO (Daftar Pencarian Orang)
     */
    public function cetakDpo()
    {
        $data = Dpo::latest()->get();
        $pdf = Pdf::loadView('reports.dpo-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-DPO.pdf');
    }

    public function cetakDpoSatuan($id)
    {
        $item = Dpo::findOrFail($id);
        $pdf = Pdf::loadView('reports.dpo-tunggal-pdf', compact('item'))->setPaper('a4', 'portrait');
        return $pdf->stream('Lembar-DPO-' . $item->nama_lengkap . '.pdf');
    }

    /**
     * WNA (Pengawasan Orang Asing)
     */
    public function cetakWna()
    {
        $data = Wna::latest()->get();
        $pdf = Pdf::loadView('reports.wna-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-WNA.pdf');
    }

    public function cetakWnaSatuan($id)
    {
        $item = Wna::findOrFail($id);
        $pdf = Pdf::loadView('reports.wna-tunggal-pdf', compact('item'));
        return $pdf->stream('Biodata-WNA-' . $item->nama_lengkap . '.pdf');
    }

    /**
     * ORMAS & PAKEM
     */
    public function cetakOrmas()
    {
        $data = Ormas::latest()->get();
        $pdf = Pdf::loadView('reports.ormas-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Data-Ormas.pdf');
    }

    public function cetakOrmasSatuan($id)
    {
        $item = Ormas::findOrFail($id);
        $pdf = Pdf::loadView('reports.ormas-tunggal-pdf', compact('item'));
        return $pdf->stream('Profil-Ormas-' . $item->nama_organisasi . '.pdf');
    }

    /**
     * PAM SDO (Pengamanan Sumber Daya Organisasi)
     */
    public function cetakPamSdo()
    {
        $data = PamSdo::latest()->get();
        $pdf = Pdf::loadView('reports.pam-sdo-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Giat-PAM-SDO.pdf');
    }

    public function cetakPamSdoSatuan($id)
    {
        $item = PamSdo::findOrFail($id);
        $pdf = Pdf::loadView('reports.pam-sdo-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Giat-PAM-' . $id . '.pdf');
    }

    /**
     * JMS (Jaksa Masuk Sekolah)
     */
    public function cetakJms()
    {
        $data = JmsActivity::latest()->get();
        $pdf = Pdf::loadView('reports.jms-pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Rekap-Kegiatan-JMS.pdf');
    }

    public function cetakJmsSatuan($id)
    {
        $item = JmsActivity::findOrFail($id);
        $pdf = Pdf::loadView('reports.jms-tunggal-pdf', compact('item'));
        return $pdf->stream('Laporan-Kegiatan-JMS-' . $id . '.pdf');
    }
}

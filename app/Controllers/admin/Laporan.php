<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use \Hermawan\DataTables\DataTable;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\Color;

class Laporan extends BaseController
{
    use ResponseTrait;
    protected $kk;
    protected $anggota;
    protected $ksp;
    protected $wijk;
    protected $baptis;
    protected $sidi;
    protected $nikah;
    protected $anggotaKeluarga;
    protected $jemaatKK;
    protected $meninggal;
    protected $pindah;
    protected $conn;
    protected $lastKK;
    protected $no;
    public function __construct()
    {
        $this->kk = new \App\Models\KkModel();
        $this->anggota = new \App\Models\AnggotaKKModel();
        $this->ksp = new \App\Models\KspModel();
        $this->wijk = new \App\Models\WijkModel();
        $this->baptis = new \App\Models\BaptisModel();
        $this->sidi = new \App\Models\SidiModel();
        $this->nikah = new \App\Models\NikahModel();
        $this->anggotaKeluarga = new \App\Models\AnggotaKeluargaModel();
        $this->jemaatKK = new \App\Models\JemaatKKModel();
        $this->meninggal = new \App\Models\MeninggalModel();
        $this->pindah = new \App\Models\PindahModel();
        $this->conn = \Config\Database::connect();
        $this->lastKK = "";
        $this->no = 1;
        helper("find");
    }

    public function index()
    {
        $list['lists'] = [
            ["url" => enkrip("layakBaptis"), "text" => "Baptis"],
            ["url" => enkrip("layakSidi"), "text" => "SIDI"],
            ["url" => enkrip("kepalaKeluarga"), "text" => "Keluarga"],
            ["url" => enkrip("anggotaJemaat"), "text" => "Anggota Jemaat"],
            ["url" => enkrip("ulangTahun"), "text" => "Ulang Tahun"],
            ["url" => enkrip("golonganDarah"), "text" => "Golongan Darah"],
            ["url" => enkrip("lansia"), "text" => "Lansia"],
            ["url" => enkrip("meninggal"), "text" => "Meninggal"],
            // ["url" => enkrip("disabilitas"), "text" => "Disabilitas"],
            // ["url" => enkrip("narkoba"), "text" => "Nakoba"],
            // ["url" => enkrip("nikahGereja"), "text" => "Nikah Gereja"],
            // ["url" => enkrip("unsur"), "text" => "Unsur"],
        ];
        $setItem = $this->request->getGet("item");
        if (is_null($setItem)) {
            $list['title'] = "Baptis";
            $list['url'] = enkrip("layakBaptis");
            return view('admin/laporan/layak_baptis', $list);
        } else if (dekrip($setItem) == "layakBaptis") {
            $list['title'] = "Baptis";
            $list['url'] = enkrip("layakBaptis");
            return view('admin/laporan/layak_baptis', $list);
        } else if (dekrip($setItem) == "layakSidi") {
            $list['title'] = "SIDI";
            $list['url'] = enkrip("layakSidi");
            return view('admin/laporan/layak_sidi', $list);
        } else if (dekrip($setItem) == "kepalaKeluarga") {
            $list['title'] = "Kepala Keluarga";
            $list['url'] = enkrip("kepalaKeluarga");
            return view('admin/laporan/kepala_keluarga', $list);
        } else if (dekrip($setItem) == "anggotaJemaat") {
            $list['title'] = "Anggota Jemaat";
            $list['url'] = enkrip("anggotaJemaat");
            return view('admin/laporan/anggota_jemaat', $list);
        } else if (dekrip($setItem) == "ulangTahun") {
            $list['title'] = "Ulang Tahun";
            $list['url'] = enkrip("ulangTahun");
            return view('admin/laporan/ulang_tahun', $list);
        } else if (dekrip($setItem) == "golonganDarah") {
            $list['title'] = "Golongan Darah";
            $list['url'] = enkrip("golonganDarah");
            return view('admin/laporan/golongan_darah', $list);
        } else if (dekrip($setItem) == "lansia") {
            $list['title'] = "Lansia";
            $list['url'] = enkrip("lansia");
            return view('admin/laporan/lansia', $list);
        } else if (dekrip($setItem) == "unsur") {
            $list['title'] = "Unsur";
            $list['url'] = enkrip("unsur");
            return view('admin/laporan/unsur', $list);
        } else if (dekrip($setItem) == "meninggal") {
            $list['title'] = "Meninggal";
            $list['url'] = enkrip("meninggal");
            return view('admin/laporan/meninggal', $list);
        }
        // else if (dekrip($setItem) == "disabilitas") {
        //     $list['title'] = "Disabilitas";
        //     $list['url'] = enkrip("disabilitas");
        //     return view('admin/laporan/disabilitas', $list);
        // } else if (dekrip($setItem) == "narkoba") {
        //     $list['title'] = "Narkoba";
        //     $list['url'] = enkrip("narkoba");
        //     return view('admin/laporan/narkoba', $list);
        // } else if (dekrip($setItem) == "nikahGereja") {
        //     $list['title'] = "Nikah Gereja";
        //     $list['url'] = enkrip("nikahGereja");
        //     return view('admin/laporan/nikahGereja', $list);
        // }
    }

    public function layak_baptis()
    {
        $params = $this->request->getGet();
        if ($params['set_status'] == 'belum') {
            $data = $this->anggota->layak_baptis(session()->get("jemaat_id"), $params['wijk']);
            $item = DataTable::of($data)
                ->addNumbering('no')
                ->add('status_baptis', function ($row) {
                    if (!is_null($row->tanggal_baptis) && !is_null($row->tempat_baptis)) {
                        return "Sudah";
                    } else {
                        return "Belum";
                    }
                })
                ->toJson(true);
            return $item;
        } else {
            $data = $this->anggota->sudah_baptis(session()->get("jemaat_id"), $params['wijk']);
            $item = DataTable::of($data)
                ->addNumbering('no')
                ->add('status_baptis', function ($row) {
                    if (!is_null($row->tanggal_baptis) && !is_null($row->tempat_baptis)) {
                        return "Sudah";
                    } else {
                        return "Belum";
                    }
                })
                ->toJson(true);
            return $item;
        }
    }
    public function layak_sidi()
    {
        $params = $this->request->getGet();
        if ($params['set_status'] == 'belum') {
            $data = $this->anggota->layak_sidi(session()->get("jemaat_id"), $params['wijk']);
            $item = DataTable::of($data)
                ->addNumbering('no')
                ->add('status_sidi', function ($row) {
                    if (!is_null($row->tanggal_sidi) && !is_null($row->tempat_sidi)) {
                        return "Sudah";
                    } else {
                        return "Belum";
                    }
                })
                ->toJson(true);
            return $item;
        } else {
            $data = $this->anggota->sudah_sidi(session()->get("jemaat_id"), $params['wijk']);
            $item = DataTable::of($data)
                ->addNumbering('no')
                ->add('status_sidi', function ($row) {
                    if (!is_null($row->tanggal_sidi) && !is_null($row->tempat_sidi)) {
                        return "Sudah";
                    } else {
                        return "Belum";
                    }
                })
                ->toJson(true);
            return $item;
        }
    }

    public function lansia()
    {
        $data = $this->anggota->lansia(session()->get("jemaat_id"));
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->toJson(true);
        return $item;
    }

    public function meninggal()
    {
        $data = $this->meninggal->get(session()->get("jemaat_id"));
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->toJson(true);
        return $item;
    }

    public function pindah()
    {
        $data = $this->pindah->get(session()->get("jemaat_id"));
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->toJson(true);
        return $item;
    }

    public function unsur()
    {
        $param = $this->request->getGet();
        $data = $this->anggota->unsur(session()->get("jemaat_id"), $param['ksp_id'], isset($param['unsur']) ? $param['unsur'] : NULL)->get()->getResult();
        $this->respond($data);
    }

    public function anggota_jemaat()
    {
        $data = $this->wijk->asObject()->where('jemaat_id', session()->get('jemaat_id'))->findAll();
        foreach ($data as $key => $wijk) {
            $wijk->ksps = $this->ksp->where("wijk_id", $wijk->id)->findAll();
        }
        return $this->respond($data);
    }

    public function getDataJemaat()
    {
        $param = (array) $data = $this->request->getJSON();
        try {
            $data = $this->anggota->LaporanAnggotaJemaat(session()->get('jemaat_id'), isset($param['wijk']) ? $param['wijk'] : NULL, isset($param['ksp_id']) ? $param['ksp_id'] : NULL, isset($param['unsur']) ? $param['unsur'] : NULL);
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function print()
    {
        $setItem = $this->request->getGet("item");
        if (is_null($setItem)) {
            $list['title'] = "";
            return view('admin/laporan/index', $list);
        } else if (dekrip($setItem) == "layakBaptis") {
            $list['title'] = "Baptis";
            if (dekrip($this->request->getGet("set_status")) == 'belum') {
                $data['anggota'] = $this->anggota->layak_baptis(session()->get("jemaat_id"), dekrip($this->request->getGet("wijk")))->orderBy('wijk, umur', 'ACS')->get()->getResultArray();
                $data['setStatus'] = 'belum';
            } else {
                $data['anggota'] = $this->anggota->sudah_baptis(session()->get("jemaat_id"), dekrip($this->request->getGet("wijk")))->orderBy('wijk, umur', 'ACS')->get()->getResultArray();
                $data['setStatus'] = 'sudah';
            }
            return view('admin/laporan/cetak_baptis', $data);
        } else if (dekrip($setItem) == "layakSidi") {
            $list['title'] = "SIDI";
            if (dekrip($this->request->getGet("set_status")) == 'belum') {
                $data['anggota'] = $this->anggota->layak_sidi(session()->get("jemaat_id"), dekrip($this->request->getGet("wijk")))->orderBy('wijk, umur', 'ACS')->get()->getResultArray();
                $data['setStatus'] = 'belum';
            } else {
                $data['anggota'] = $this->anggota->sudah_sidi(session()->get("jemaat_id"), dekrip($this->request->getGet("wijk")))->orderBy('wijk, umur', 'ACS')->get()->getResultArray();
                $data['setStatus'] = 'sudah';
            }
            return view('admin/laporan/cetak_sidi', $data);
        } else if (dekrip($setItem) == "kepalaKeluarga") {
            $param = $this->request->getGet();
            // dd($param);
            $list['title'] = "Kepala Keluarga";
            $data['anggota'] = $this->jemaatKK->LaporanKepalaKeluarga(session()->get('jemaat_id'), isset($param['wijk_id']) ? dekrip($param['wijk_id']) : NULL, isset($param['ksp_id']) ? dekrip($param['ksp_id']) : NULL)->getResultArray();
            return view('admin/laporan/cetak_kepala_keluarga', $data);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $setItem = $this->request->getGet("item");
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK')
            ->setCellValue('C3', 'KSP')
            ->setCellValue('D3', 'KODE')
            ->setCellValue('E3', 'NAMA LENGKAP')
            ->setCellValue('F3', 'JENIS KELAMIN')
            ->setCellValue('G3', 'TANGGAL LAHIR')
            ->setCellValue('H3', 'UMUR')
            ->setCellValue('I3', 'HUBUNGAN DALAM KELUARGA')
            ->setCellValue('J3', 'PEKERJAAN')
            ->setCellValue('K3', 'KEPALA KELUARGA')
            ->setCellValue('L3', 'INTRA');

        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');

        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(40, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(80, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(65, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(220, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(115, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(92, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(139, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("J")->setWidth(200, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("K")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("L")->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'GEREJA KRISTEN INJILI DI TANAH PAPUA');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        if (dekrip($this->request->getGet('set_status')) == 'sudah') {
            $spreadsheet->getActiveSheet()->mergeCells("A1:O1");
            $spreadsheet->getActiveSheet()->mergeCells("A2:O2");
            $spreadsheet->getActiveSheet()->getStyle("A3:O3")->getFont()->setBold(true)->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle("A3:O3")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A3:O3")->getAlignment()->setVertical('center');
            $spreadsheet->getActiveSheet()->getColumnDimension("M")->setWidth(90, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension("N")->setWidth(103, 'px');
            $spreadsheet->getActiveSheet()->getColumnDimension("O")->setWidth(124, 'px');
            $spreadsheet->getActiveSheet()->getStyle("M3")->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle("N3")->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle("O3")->getAlignment()->setWrapText(true);
        } else {
            $spreadsheet->getActiveSheet()->mergeCells("A1:L1");
            $spreadsheet->getActiveSheet()->mergeCells("A2:L2");
            $spreadsheet->getActiveSheet()->getStyle("A3:L3")->getFont()->setBold(true)->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle("A3:L3")->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle("A3:L3")->getAlignment()->setVertical('center');
        }
        if (dekrip($setItem) == "layakBaptis") {
            if (dekrip($this->request->getGet('set_status')) == 'sudah') {
                $data = $this->anggota->sudah_baptis(session()->get("jemaat_id"), dekrip($this->request->getGet('wijk')))->orderBy('wijk, umur', 'ACS')->get()->getResult();
                $sheet->setCellValue('M3', 'TANGGAL BAPTIS')
                    ->setCellValue('N3', 'TEMPAT BAPTIS')
                    ->setCellValue('O3', 'NAMA PENDETA');
                $spreadsheet->getActiveSheet()->getStyle("A3:O" . count($data) + 3)->applyFromArray($styleArray);
            } else {
                $data = $this->anggota->layak_baptis(session()->get("jemaat_id"), dekrip($this->request->getGet("wijk")))->orderBy('wijk, umur', 'ACS')->get()->getResult();
                $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            }
            foreach ($data as $key => $anggota) {
                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota->wijk)
                    ->setCellValue('C' . $key + 4, $anggota->ksp)
                    ->setCellValue('D' . $key + 4, $anggota->kode_kk)
                    ->setCellValue('E' . $key + 4, $anggota->nama)
                    ->setCellValue('F' . $key + 4, $anggota->sex)
                    ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                    ->setCellValue('H' . $key + 4, $anggota->umur)
                    ->setCellValue('I' . $key + 4, $anggota->hubungan_keluarga)
                    ->setCellValue('J' . $key + 4, $anggota->pekerjaan)
                    ->setCellValue('K' . $key + 4, $this->getKK($anggota->kk_id))
                    ->setCellValue('L' . $key + 4, $anggota->unsur);
                if (dekrip($this->request->getGet('set_status')) == 'sudah') {
                    $sheet->setCellValue('M' . $key + 4, $anggota->tanggal_baptis)
                        ->setCellValue('N' . $key + 4, $anggota->tempat_baptis)
                        ->setCellValue('O' . $key + 4, $anggota->pendeta);
                }
            }
            $sheet->setCellValue('A2', 'DAFTAR JEMAAT ' . strtoupper(dekrip($this->request->getGet('set_status'))) . ' BAPTIS WIJK ' . strtoupper($data[0]->wijk));
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-Baptis';
        } else if (dekrip($setItem) == "layakSidi") {
            if (dekrip($this->request->getGet('set_status')) == 'sudah') {
                $data = $this->anggota->sudah_sidi(session()->get("jemaat_id"), dekrip($this->request->getGet('wijk')))->orderBy('wijk, umur', 'ACS')->get()->getResult();
                $sheet->setCellValue('M3', 'TANGGAL SIDI')
                    ->setCellValue('N3', 'TEMPAT SIDI')
                    ->setCellValue('O3', 'NAMA PENDETA');
                $spreadsheet->getActiveSheet()->getStyle("A3:O" . count($data) + 3)->applyFromArray($styleArray);
            } else {
                $data = $this->anggota->layak_sidi(session()->get("jemaat_id"), dekrip($this->request->getGet('wijk')))->orderBy('wijk, umur', 'ACS')->get()->getResult();
                $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            }
            foreach ($data as $key => $anggota) {
                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota->wijk)
                    ->setCellValue('C' . $key + 4, $anggota->ksp)
                    ->setCellValue('D' . $key + 4, $anggota->kode_kk)
                    ->setCellValue('E' . $key + 4, $anggota->nama)
                    ->setCellValue('F' . $key + 4, $anggota->sex)
                    ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                    ->setCellValue('H' . $key + 4, $anggota->umur)
                    ->setCellValue('I' . $key + 4, $anggota->hubungan_keluarga)
                    ->setCellValue('J' . $key + 4, $anggota->pekerjaan)
                    ->setCellValue('K' . $key + 4, $this->getKK($anggota->kk_id))
                    ->setCellValue('L' . $key + 4, $anggota->unsur);
                if (dekrip($this->request->getGet('set_status')) == 'sudah') {
                    $sheet->setCellValue('M' . $key + 4, $anggota->tanggal_sidi)
                        ->setCellValue('N' . $key + 4, $anggota->tempat_sidi)
                        ->setCellValue('O' . $key + 4, $anggota->pendeta);
                }
            }
            $sheet->setCellValue('A2', 'DAFTAR JEMAAT ' . strtoupper(dekrip($this->request->getGet('set_status'))) . ' SIDI WIJK ' . strtoupper($data[0]->wijk));
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-SIDI';
        } else if (dekrip($setItem) == "ulangTahun") {
            $param = $this->request->getGet();
            $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(117, 'px');
            $sheet->setCellValue('G3', $param['jenis'] == '1' ? 'TANGGAL LAHIR' : 'TANGGAL PERNIKAHAN')
                ->setCellValue('H3', $param['jenis'] == '1' ? 'UMUR' : 'UMUR PERNIKAHAN');
            $result = $this->anggota->getUltahWeak(session()->get("jemaat_id"), $param);
            if ($param['jenis'] == '1') {
                $data = $result;
            } else {
                $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(111, 'px');
                $spreadsheet->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);
                $data = filterData($result, 'hubungan_keluarga', ['KEPALA KELUARGA', 'SUAMI'], 'or');
            }
            $sheet->setCellValue('A2', $param['jenis'] == '1' ? 'DAFTAR ULANG TAHUN KELAHIRAN TANGGAL ' . $param['start'] . ' S/D ' . $param['end'] : 'DAFTAR ULANG TAHUN PERNIKAHAN TANGGAL ' . $param['start'] . ' S/D ' . $param['end']);
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
            $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            foreach ($data as $key => $anggota) {

                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota->wijk)
                    ->setCellValue('C' . $key + 4, $anggota->ksp)
                    ->setCellValue('D' . $key + 4, $anggota->kode_kk)
                    ->setCellValue('E' . $key + 4, $anggota->nama)
                    ->setCellValue('F' . $key + 4, $anggota->sex)
                    ->setCellValue('G' . $key + 4, $param['jenis'] == '1' ? $anggota->tanggal_lahir : $anggota->tanggal_nikah)
                    ->setCellValue('H' . $key + 4, $anggota->umur)
                    ->setCellValue('I' . $key + 4, $anggota->hubungan_keluarga)
                    ->setCellValue('J' . $key + 4, $anggota->pekerjaan)
                    ->setCellValue('K' . $key + 4, $anggota->kepala)
                    ->setCellValue('L' . $key + 4, $anggota->unsur);
            }
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-daftar ulang tahun';
        } else if (dekrip($setItem) == "lansia") {
            $data = $this->anggota->lansia(session()->get("jemaat_id"))->get()->getResult();
            $sheet->setCellValue('A2', 'DAFTAR LANSIA');
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
            $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            foreach ($data as $key => $anggota) {

                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota->wijk)
                    ->setCellValue('C' . $key + 4, $anggota->ksp)
                    ->setCellValue('D' . $key + 4, $anggota->kode_kk)
                    ->setCellValue('E' . $key + 4, $anggota->nama)
                    ->setCellValue('F' . $key + 4, $anggota->sex)
                    ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                    ->setCellValue('H' . $key + 4, $anggota->umur)
                    ->setCellValue('I' . $key + 4, $anggota->hubungan_keluarga)
                    ->setCellValue('J' . $key + 4, $anggota->pekerjaan)
                    ->setCellValue('K' . $key + 4, $this->getKK($anggota->kk_id))
                    ->setCellValue('L' . $key + 4, $anggota->unsur);
            }
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-lansia';
        } else if (dekrip($setItem) == "meninggal") {
            $data = $this->meninggal->get(session()->get("jemaat_id"))->get()->getResult();
            $sheet->setCellValue('A2', 'DAFTAR JEMAAT MENINGGAL');
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
            $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            foreach ($data as $key => $anggota) {

                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota->wijk)
                    ->setCellValue('C' . $key + 4, $anggota->ksp)
                    ->setCellValue('D' . $key + 4, $anggota->kode_kk)
                    ->setCellValue('E' . $key + 4, $anggota->nama)
                    ->setCellValue('F' . $key + 4, $anggota->sex)
                    ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                    ->setCellValue('H' . $key + 4, $anggota->umur)
                    ->setCellValue('I' . $key + 4, $anggota->hubungan_keluarga)
                    ->setCellValue('J' . $key + 4, $anggota->pekerjaan)
                    ->setCellValue('K' . $key + 4, $this->getKK($anggota->kk_id))
                    ->setCellValue('L' . $key + 4, $anggota->unsur);
            }
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-lansia';
        } else if (dekrip($setItem) == "kepalaKeluarga") {
            $wijk_id = $this->request->getVar("wijk_id");
            $ksp_id = $this->request->getVar("ksp_id");
            $data = $this->jemaatKK->asObject()->LaporanKepalaKeluarga(session()->get('jemaat_id'), isset($wijk_id) ? dekrip($wijk_id) : NULL, isset($ksp_id) ? dekrip($ksp_id) : NULL)->getResultArray();
            // $data = $this->meninggal->get(session()->get("jemaat_id"))->get()->getResult();
            $sheet->setCellValue('A2', 'DAFTAR KELUARGA');
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
            $spreadsheet->getActiveSheet()->getStyle("A3:L" . count($data) + 3)->applyFromArray($styleArray);
            foreach ($data as $key => $anggota) {

                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota['wijk'])
                    ->setCellValue('C' . $key + 4, $anggota['ksp'])
                    ->setCellValue('D' . $key + 4, $anggota['kode_kk'])
                    ->setCellValue('E' . $key + 4, $anggota['nama'])
                    ->setCellValue('F' . $key + 4, $anggota['sex'])
                    ->setCellValue('G' . $key + 4, $anggota['tanggal_lahir'])
                    ->setCellValue('H' . $key + 4, $anggota['umur'])
                    ->setCellValue('I' . $key + 4, $anggota['hubungan_keluarga'])
                    ->setCellValue('J' . $key + 4, $anggota['pekerjaan'])
                    ->setCellValue('K' . $key + 4, $this->getKK($anggota['kk_id']))
                    ->setCellValue('L' . $key + 4, $anggota['unsur']);
            }
            $writer = new Xlsx($spreadsheet);
            $filename = date('Y-m-d-His') . '-keluarga';
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function anggota_excel()
    {
        $param = $this->request->getGet();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $setItem = $this->request->getGet("item");
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK/KSP')
            ->setCellValue('C3', 'KODE KK')
            ->setCellValue('D3', 'NAMA LENGKAP')
            ->setCellValue('E3', 'JENIS KELAMIN')
            ->setCellValue('F3', 'TEMPAT LAHIR')
            ->setCellValue('G3', 'TANGGAL LAHIR')
            ->setCellValue('H3', 'GOLONGAN DARAH')
            ->setCellValue('I3', 'STATUS KAWIN')
            ->setCellValue('J3', 'HUBUNGAN KELUARGA')
            ->setCellValue('K3', 'PENDIDIKAN TERAKHIR')
            ->setCellValue('L3', 'GELAR')
            ->setCellValue('M3', 'PEKERJAAN')
            ->setCellValue('N3', 'ASAL GEREJA')
            ->setCellValue('O3', 'NAMA AYAH')
            ->setCellValue('P3', 'NAMA IBU')
            ->setCellValue('Q3', 'SUKU')
            ->setCellValue('R3', 'STATUS DOMISILI')
            ->setCellValue('S3', 'UNSUR')
            ->setCellValue('T3', 'KEPALA KELUARGA')
            ->setCellValue('U3', 'UMUR')
            ->setCellValue('V3', 'DISABILITAS')
            ->setCellValue('W3', 'BARKOBA')
            ->setCellValue('X3', 'NIKAH GEREJA');
        $spreadsheet->getActiveSheet()->mergeCells("A1:X1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:X2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A3:X3")->getFont()->setBold(true)->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:X3")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:X3")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("J3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("K3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("E3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("R3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("S3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("X3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(69, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(221, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(94, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(115, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(92, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(97, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("J")->setWidth(141, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("K")->setWidth(222, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("L")->setWidth(75, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("M")->setWidth(245, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("N")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("O")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("P")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("Q")->setWidth(116, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("R")->setWidth(86, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("S")->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("T")->setWidth(208, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("V")->setWidth(85, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("W")->setWidth(85, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("X")->setWidth(85, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'GEREJA KRISTEN INJILI DI TANAH PAPUA');

        $data = $this->anggota->LaporanAnggotaJemaat(
            session()->get('jemaat_id'),
            isset($param['wijk_id']) ? dekrip($param['wijk_id']) : NULL,
            isset($param['ksp_id']) ? dekrip($param['ksp_id']) : NULL,
            isset($param['unsur']) ? dekrip($param['unsur']) : NULL
        );

        if (isset($param['wijk_id']) && !isset($param['ksp_id']) && !isset($param['unsur'])) {
            $wijk = $this->wijk->where('id', dekrip($param['wijk_id']))->first()['wijk'];
            $pesan = " WIJK " . strtoupper($wijk);
        } else if (isset($param['ksp_id']) && isset($param['unsur'])) {
            $ksp = $this->ksp->where('id', dekrip($param['ksp_id']))->first();
            $wijk = $this->wijk->first($ksp['wijk_id']);
            $pesan = " WIJK " . strtoupper($wijk['wijk']) . " | KSP " . $ksp['ksp'] . " | UNSUR " . strtoupper(dekrip($param['unsur']));
        } else if (isset($param['wijk_id']) && !isset($param['ksp_id']) && isset($param['unsur'])) {
            $wijk = $this->wijk->where('id', dekrip($param['wijk_id']))->first();
            $pesan = " WIJK " . strtoupper($wijk['wijk']) . " | UNSUR " . strtoupper(dekrip($param['unsur']));
        } else if (!isset($param['wijk_id']) && !isset($param['ksp_id']) && isset($param['unsur'])) {
            $pesan = " UNSUR " . strtoupper(dekrip($param['unsur']));
        } else if (isset($param['ksp_id']) && !isset($param['unsur'])) {
            $ksp = $this->ksp->where('id', dekrip($param['ksp_id']))->first();
            $wijk = $this->wijk->first($ksp['wijk_id']);
            $pesan = " WIJK " . strtoupper($wijk['wijk']) . " | KSP " . $ksp['ksp'];
        }
        $sheet->setCellValue('A2', 'DAFTAR ANGGOTA JEMAAT' . $pesan);
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:X" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->wijk . '/' . $anggota->ksp)
                ->setCellValue('C' . $key + 4, $anggota->kode_kk)
                ->setCellValue('D' . $key + 4, $anggota->nama)
                ->setCellValue('E' . $key + 4, $anggota->sex)
                ->setCellValue('F' . $key + 4, $anggota->tempat_lahir)
                ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                ->setCellValue('H' . $key + 4, $anggota->golongan_darah)
                ->setCellValue('I' . $key + 4, $anggota->status_kawin)
                ->setCellValue('J' . $key + 4, $anggota->hubungan_keluarga)
                ->setCellValue('K' . $key + 4, $anggota->pendidikan_terakhir)
                ->setCellValue('L' . $key + 4, $anggota->gelar_terakhir)
                ->setCellValue('M' . $key + 4, $anggota->pekerjaan)
                ->setCellValue('N' . $key + 4, $anggota->asal_gereja)
                ->setCellValue('O' . $key + 4, $anggota->nama_ayah)
                ->setCellValue('P' . $key + 4, $anggota->nama_ibu)
                ->setCellValue('Q' . $key + 4, $anggota->suku)
                ->setCellValue('R' . $key + 4, $anggota->status_domisili)
                ->setCellValue('S' . $key + 4, $anggota->unsur)
                ->setCellValue('T' . $key + 4, $anggota->kepala)
                ->setCellValue('U' . $key + 4, $anggota->umur)
                ->setCellValue('V' . $key + 4, $anggota->disabilitas == '0' ? 'Tidak' : 'Ya')
                ->setCellValue('W' . $key + 4, $anggota->status_narkoba == '0' ? 'Tidak' : 'Ya')
                ->setCellValue('X' . $key + 4, $anggota->nikah_gereja == '0' ? 'Belum' : 'Sudah');
        }
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-Data Anggota';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function meninggal_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK/KSP')
            ->setCellValue('C3', 'KODE KK')
            ->setCellValue('D3', 'NIK')
            ->setCellValue('E3', 'NAMA JEMAAT')
            ->setCellValue('F3', 'TANGGAL MENINGGAL')
            ->setCellValue('G3', 'JENIS KELAMIN')
            ->setCellValue('H3', 'UMUR SAAT MENINGGAL')
            ->setCellValue('I3', 'PENYEBAB')
            ->setCellValue('J3', 'UNSUR')
            ->setCellValue('K3', 'SUKU');
        $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getFont()->setBold(true)->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("F3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("J3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(69, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(130, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(226, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(143, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(97, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("J")->setWidth(141, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);

        $sheet->setCellValue('A1', 'GEREJA KRISTEN INJILI DI TANAH PAPUA');
        $data = $this->meninggal->get(session()->get('jemaat_id'))->get()->getResult();
        // dd($data);
        $sheet->setCellValue('A2', 'DAFTAR JEMAAT MENINGGAL ');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:K" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $rt = new RichText();
            $rt->createText($anggota->nik);
            // $spreadsheet->getActiveSheet()->getCell('D' . $key + 4)
            //     ->setValueExplicit(16, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->wijk_ksp)
                ->setCellValue('C' . $key + 4, $anggota->kode_kk)
                ->setCellValue('D' . $key + 4, $rt)
                ->setCellValue('E' . $key + 4, $anggota->nama)
                ->setCellValue('F' . $key + 4, $anggota->tanggal_meninggal)
                ->setCellValue('G' . $key + 4, $anggota->sex)
                ->setCellValue('H' . $key + 4, $anggota->umur)
                ->setCellValue('I' . $key + 4, $anggota->penyebab)
                ->setCellValue('J' . $key + 4, $anggota->unsur)
                ->setCellValue('K' . $key + 4, $anggota->suku);
            $sheet->getStyle('D' . $key + 4)->getNumberFormat()->setFormatCode('@');
        }
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-meninggal';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function pindah_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK/KSP')
            ->setCellValue('C3', 'KODE KK')
            ->setCellValue('D3', 'NIK')
            ->setCellValue('E3', 'NAMA JEMAAT')
            ->setCellValue('F3', 'TANGGAL LAHIR')
            ->setCellValue('G3', 'JENIS KELAMIN')
            ->setCellValue('H3', 'TUJUAN PINDAH')
            ->setCellValue('I3', 'TANGGAL PINDAH')
            ->setCellValue('J3', 'UNSUR')
            ->setCellValue('K3', 'SUKU');
        $spreadsheet->getActiveSheet()->mergeCells("A1:K1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:K2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getFont()->setBold(true)->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:K3")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("F3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("J3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(69, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(130, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(226, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(143, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(97, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("J")->setWidth(141, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);

        $sheet->setCellValue('A1', 'GEREJA KRISTEN INJILI DI TANAH PAPUA');
        $data = $this->pindah->get(session()->get('jemaat_id'))->get()->getResult();
        // dd($data);
        $sheet->setCellValue('A2', 'DAFTAR JEMAAT PINDAH');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:K" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $rt = new RichText();
            $rt->createText($anggota->nik);
            // $spreadsheet->getActiveSheet()->getCell('D' . $key + 4)
            //     ->setValueExplicit(16, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->wijk_ksp)
                ->setCellValue('C' . $key + 4, $anggota->kode_kk)
                ->setCellValue('D' . $key + 4, $rt)
                ->setCellValue('E' . $key + 4, $anggota->nama)
                ->setCellValue('F' . $key + 4, $anggota->tanggal_pindah)
                ->setCellValue('G' . $key + 4, $anggota->sex)
                ->setCellValue('H' . $key + 4, $anggota->tujuan)
                ->setCellValue('I' . $key + 4, $anggota->tanggal_pindah)
                ->setCellValue('J' . $key + 4, $anggota->unsur)
                ->setCellValue('K' . $key + 4, $anggota->suku);
            $sheet->getStyle('D' . $key + 4)->getNumberFormat()->setFormatCode('@');
        }
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-pindah';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function golongan_darah_excel()
    {
        $darah = $this->request->getGet('darah');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $setItem = $this->request->getGet("item");
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK/KSP')
            ->setCellValue('C3', 'KODE KK')
            ->setCellValue('D3', 'NAMA LENGKAP')
            ->setCellValue('E3', 'JENIS KELAMIN')
            ->setCellValue('F3', 'TEMPAT LAHIR')
            ->setCellValue('G3', 'TANGGAL LAHIR')
            ->setCellValue('H3', 'GOLONGAN DARAH')
            ->setCellValue('I3', 'STATUS KAWIN')
            ->setCellValue('J3', 'HUBUNGAN KELUARGA')
            ->setCellValue('K3', 'PENDIDIKAN')
            ->setCellValue('L3', 'GELAR')
            ->setCellValue('M3', 'PEKERJAAN')
            ->setCellValue('N3', 'ASAL GEREJA')
            ->setCellValue('O3', 'NAMA AYAH')
            ->setCellValue('P3', 'NAMA IBU')
            ->setCellValue('Q3', 'SUKU')
            ->setCellValue('R3', 'STATUS DOMISILI')
            ->setCellValue('S3', 'UNSUR');
        $spreadsheet->getActiveSheet()->mergeCells("A1:S1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:S2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A3:S3")->getFont()->setBold(true)->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:S3")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A3:S3")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("J3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("E3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("H3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("R3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("S3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(69, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(221, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(94, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(115, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(92, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(89, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(97, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("J")->setWidth(141, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("K")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("L")->setWidth(75, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("M")->setWidth(245, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("N")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("O")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("P")->setWidth(170, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("Q")->setWidth(116, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("R")->setWidth(86, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("S")->setWidth(55, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'GEREJA KRISTEN INJILI DI TANAH PAPUA');
        $data = $this->anggota->getGolonganDarah(session()->get('jemaat_id'), dekrip($darah));
        $sheet->setCellValue('A2', 'DAFTAR ANGGOTA JEMAAT BERGOLONGAN DARAH ' . '"' . dekrip($darah) . '"');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:S" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->wijk . '/' . $anggota->ksp)
                ->setCellValue('C' . $key + 4, $anggota->kode_kk)
                ->setCellValue('D' . $key + 4, $anggota->nama)
                ->setCellValue('E' . $key + 4, $anggota->sex)
                ->setCellValue('F' . $key + 4, $anggota->tempat_lahir)
                ->setCellValue('G' . $key + 4, $anggota->tanggal_lahir)
                ->setCellValue('H' . $key + 4, $anggota->golongan_darah)
                ->setCellValue('I' . $key + 4, $anggota->status_kawin)
                ->setCellValue('J' . $key + 4, $anggota->hubungan_keluarga)
                ->setCellValue('K' . $key + 4, $anggota->pendidikan_terakhir)
                ->setCellValue('L' . $key + 4, $anggota->gelar_terakhir)
                ->setCellValue('M' . $key + 4, $anggota->pekerjaan)
                ->setCellValue('N' . $key + 4, $anggota->asal_gereja)
                ->setCellValue('O' . $key + 4, $anggota->nama_ayah)
                ->setCellValue('P' . $key + 4, $anggota->nama_ibu)
                ->setCellValue('Q' . $key + 4, $anggota->suku)
                ->setCellValue('R' . $key + 4, $anggota->status_domisili)
                ->setCellValue('S' . $key + 4, $anggota->unsur);
        }
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-golongan-darah';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function getKK($kk_id)
    {
        $kks = $this->jemaatKK->getKK(session()->get("jemaat_id"));
        foreach ($kks as $key => $kk) {
            if ($kk_id == $kk->kk_id) {
                return $kk->nama;
            }
        }
        return "";
    }

    public function get_kepala_keluarga()
    {
        $param = (array) $data = $this->request->getJSON();
        // dd($param);
        $data = $this->jemaatKK->LaporanKepalaKeluarga(session()->get('jemaat_id'), isset($param['wijk']) ? $param['wijk'] : NULL, isset($param['ksp_id']) ? $param['ksp_id'] : NULL)->getResult();
        return $this->respond($data);
    }
}

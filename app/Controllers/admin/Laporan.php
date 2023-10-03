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
    protected $keluarga;
    protected $anggota;
    protected $anggotaKeluarga;
    protected $wilayah;
    protected $kerukunan;
    protected $conn;
    protected $lastKK;
    protected $no;
    public function __construct()
    {
        $this->keluarga = new \App\Models\KeluargaModel();
        $this->anggota = new \App\Models\AnggotaModel();
        $this->anggotaKeluarga = new \App\Models\AnggotaKeluargaModel();
        $this->wilayah = new \App\Models\WilayahModel();
        $this->kerukunan = new \App\Models\KerukunanModel();
        $this->conn = \Config\Database::connect();
        $this->lastKK = "";
        $this->no = 1;
        helper('find');
    }

    public function index()
    {
        $list['lists'] = [
            ["url" => enkrip("kepalaKeluarga"), "text" => "Keluarga"],
            ["url" => enkrip("golonganDarah"), "text" => "Golongan Darah"],
            // ["url" => enkrip("disabilitas"), "text" => "Disabilitas"],
            // ["url" => enkrip("narkoba"), "text" => "Nakoba"],
            // ["url" => enkrip("nikahGereja"), "text" => "Nikah Gereja"],
            // ["url" => enkrip("unsur"), "text" => "Unsur"],
        ];
        $setItem = $this->request->getGet("item");
        if (is_null($setItem) || dekrip($setItem) == "kepalaKeluarga") {
            $list['title'] = "Kepala Keluarga";
            $list['url'] = enkrip("kepalaKeluarga");
            return view('admin/laporan/kepala_keluarga', $list);
        } else if (dekrip($setItem) == "golonganDarah") {
            $list['title'] = "Golongan Darah";
            $list['url'] = enkrip("golonganDarah");
            return view('admin/laporan/golongan_darah', $list);
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

    public function lansia()
    {
        $data = $this->anggota->lansia(session()->get("jemaat_id"));
        $item = DataTable::of($data)
            ->addNumbering('no')
            ->toJson(true);
        return $item;
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
            $data['anggota'] = $this->anggota
                ->select("keluarga.*, anggota_keluarga.keluarga_id, anggota.nama, wilayah.wilayah, kerukunan.kerukunan")
                ->join("anggota_keluarga", "anggota_keluarga.anggota_id=anggota.id", "left")
                ->join("keluarga", "anggota_keluarga.keluarga_id=keluarga.id", "left")
                ->join("wilayah", "wilayah.id=keluarga.wilayah_id", "left")
                ->join("kerukunan", "kerukunan.id=keluarga.kerukunan_id", "left")
                ->where('hubungan_keluarga', "KEPALA KELUARGA")->findAll();
            return view('admin/laporan/cetak_kepala_keluarga', $data);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $setItem = $this->request->getGet("item");
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'NO KK')
            ->setCellValue('C3', 'KEPALA KELUARGA')
            ->setCellValue('D3', 'WILAYAH')
            ->setCellValue('E3', 'KERUKUNAN')
            ->setCellValue('F3', 'KONTAK')
            ->setCellValue('G3', 'ALAMAT')
            ->setCellValue('H3', 'STATUS TINGGAL');

        $spreadsheet->getActiveSheet()->mergeCells("A1:H1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:H2");
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
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'IKATAN KELUARGA TORAJA (IKT)');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        if (dekrip($setItem) == "kepalaKeluarga") {
            $data = $this->anggota
                ->select("keluarga.*, wilayah.wilayah, kerukunan.kerukunan, anggota.nama")
                ->join("anggota_keluarga", "anggota_keluarga.anggota_id = anggota.id", "left")
                ->join("keluarga", "keluarga.id = anggota_keluarga.keluarga_id", "left")
                ->join("wilayah", "wilayah.id = keluarga.wilayah_id", "left")
                ->join("kerukunan", "kerukunan.id = keluarga.kerukunan_id", "left")
                ->where("hubungan_keluarga", "KEPALA KELUARGA")
                ->where("keluarga.deleted_at", null)
                ->findAll();
            // $data = $this->meninggal->get(session()->get("jemaat_id"))->get()->getResult();
            $sheet->setCellValue('A2', 'KOTA JAYAPURA');
            $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
            $spreadsheet->getActiveSheet()->getStyle("A3:H" . count($data) + 3)->applyFromArray($styleArray);
            foreach ($data as $key => $anggota) {

                $sheet->setCellValue('A' . $key + 4, $key + 1)
                    ->setCellValue('B' . $key + 4, $anggota['nomor'])
                    ->setCellValue('C' . $key + 4, $anggota['nama'])
                    ->setCellValue('D' . $key + 4, $anggota['wilayah'])
                    ->setCellValue('E' . $key + 4, $anggota['kerukunan'])
                    ->setCellValue('F' . $key + 4, $anggota['kontak'])
                    ->setCellValue('G' . $key + 4, $anggota['alamat'])
                    ->setCellValue('H' . $key + 4, $anggota['status_tinggal']);
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
            ->setCellValue('B3', 'NIK')
            ->setCellValue('C3', 'NAMA')
            ->setCellValue('D3', 'JENIS KELAMIN')
            ->setCellValue('E3', 'TTL')
            ->setCellValue('F3', 'GOLONGAN DARAH')
            ->setCellValue('G3', 'AGAMA')
            ->setCellValue('H3', 'HUBUNGAN KELUARGA')
            ->setCellValue('I3', 'PEKERJAAN');
        $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:I2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(147, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(214, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(181, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(129, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(92, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(201, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(222, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'IKATAN KELUARGA TORAJA (IKT)');

        $data = $this->anggota->asObject()->where('deleted_at', null)->findAll();
        $sheet->setCellValue('A2', 'DAFTAR ANGGOTA IKT');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:I" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->nik)
                ->setCellValue('C' . $key + 4, $anggota->nama)
                ->setCellValue('D' . $key + 4, $anggota->gender)
                ->setCellValue('E' . $key + 4, $anggota->tempat_lahir . ', ' . $anggota->tanggal_lahir)
                ->setCellValue('F' . $key + 4, $anggota->golongan_darah)
                ->setCellValue('G' . $key + 4, $anggota->agama)
                ->setCellValue('H' . $key + 4, $anggota->hubungan_keluarga)
                ->setCellValue('I' . $key + 4, $anggota->pekerjaan);
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
            ->setCellValue('B3', 'NIK')
            ->setCellValue('C3', 'NAMA')
            ->setCellValue('D3', 'JENIS KELAMIN')
            ->setCellValue('E3', 'TTL')
            ->setCellValue('F3', 'GOLONGAN DARAH')
            ->setCellValue('G3', 'AGAMA')
            ->setCellValue('H3', 'HUBUNGAN KELUARGA')
            ->setCellValue('I3', 'PEKERJAAN');
        $spreadsheet->getActiveSheet()->mergeCells("A1:I1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:I2");
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("I3")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("G3")->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(35, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(147, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(214, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(100, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(181, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(129, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("G")->setWidth(92, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("H")->setWidth(201, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("I")->setWidth(222, 'px');
        $spreadsheet->getActiveSheet()->getRowDimension("3")->setRowHeight(33.75);
        $sheet->setCellValue('A1', 'IKATAN KELUARGA TORAJA (IKT)');

        if (dekrip($darah) == "null" || dekrip($darah) == "ALL") $data = $this->anggota->asObject()->where('deleted_at', null)->findAll();
        else $data = $this->anggota->asObject()->where('golongan_darah', dekrip($darah))->where('deleted_at', null)->findAll();
        $sheet->setCellValue('A2', 'DAFTAR ANGGOTA IKT BERDASARKAN GOLONGAN DARAH');
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $spreadsheet->getActiveSheet()->getStyle("A3:I" . count($data) + 3)->applyFromArray($styleArray);
        foreach ($data as $key => $anggota) {
            $sheet->setCellValue('A' . $key + 4, $key + 1)
                ->setCellValue('B' . $key + 4, $anggota->nik)
                ->setCellValue('C' . $key + 4, $anggota->nama)
                ->setCellValue('D' . $key + 4, $anggota->gender)
                ->setCellValue('E' . $key + 4, $anggota->tempat_lahir . ', ' . $anggota->tanggal_lahir)
                ->setCellValue('F' . $key + 4, $anggota->golongan_darah)
                ->setCellValue('G' . $key + 4, $anggota->agama)
                ->setCellValue('H' . $key + 4, $anggota->hubungan_keluarga)
                ->setCellValue('I' . $key + 4, $anggota->pekerjaan);
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
        $data = $this->anggota
            ->select("keluarga.*, wilayah.wilayah, kerukunan.kerukunan, anggota.nama")
            ->join("anggota_keluarga", "anggota_keluarga.anggota_id = anggota.id", "left")
            ->join("keluarga", "keluarga.id = anggota_keluarga.keluarga_id", "left")
            ->join("wilayah", "wilayah.id = keluarga.wilayah_id", "left")
            ->join("kerukunan", "kerukunan.id = keluarga.kerukunan_id", "left")
            ->where("hubungan_keluarga", "KEPALA KELUARGA")
            ->where("keluarga.deleted_at", null)
            ->findAll();
        return $this->respond($data);
    }
}

<?php

namespace App\Controllers;

use Support\BaseController;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;
use XBase\Enum\FieldType;
use XBase\Enum\TableType;
use XBase\Header\Column;
use XBase\Header\HeaderFactory;
use XBase\TableCreator;
use XBase\TableEditor;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConvertController extends BaseController
{
    // Controller logic here
    public function convert(Request $request)
    {
        // vd($request->all());
        if ($request->file('excelFile')) {
            $uploadDir = __DIR__ . '/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = basename($_FILES['excelFile']['name']);
            $uploadFile = $uploadDir . $fileName;
    
            if (!move_uploaded_file($_FILES['excelFile']['tmp_name'], $uploadFile)) {
                die("Error saat mengupload file.");
            }
    
            try {
                $spreadsheet = IOFactory::load($uploadFile);
                $worksheet = $spreadsheet->getActiveSheet();
    
                $data = [];
                foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                    $rowData = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $rowData[] = $cell->getValue();
                    }
                    if ($rowIndex > 1) { // Mengabaikan header
                        $data[] = $rowData;
                    }
                }
    
                // Tentukan path untuk file DBF output sementara
                $filepath = tempnam(sys_get_temp_dir(), 'dbf_') . '.dbf';  // Menggunakan file sementara
    
                // Membuat header DBF dengan tipe DBASE_III_PLUS_MEMO
                $header = HeaderFactory::create(TableType::DBASE_III_PLUS_NOMEMO);  // Menggunakan DBASE_III_PLUS_MEMO
    
                // Menambahkan kolom secara manual
                $tableCreator = new TableCreator($filepath, $header);
                $tableCreator
                    ->addColumn(new Column([
                        'name'   => 'No',
                        'type'   => FieldType::NUMERIC,
                        'length' => 10,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Nik',
                        'type'   => FieldType::CHAR,
                        'length' => 10,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Nama',
                        'type'   => FieldType::CHAR,
                        'length' => 50,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Sex',
                        'type'   => FieldType::CHAR,
                        'length' => 3,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Gol',
                        'type'   => FieldType::CHAR,
                        'length' => 10,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Dept',
                        'type'   => FieldType::CHAR,
                        'length' => 50,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Sect',
                        'type'   => FieldType::CHAR,
                        'length' => 50,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tgl_masuk',
                        'type'   => FieldType::CHAR,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Npwp',
                        'type'   => FieldType::CHAR,
                        'length' => 20,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Stat_seksi',
                        'type'   => FieldType::CHAR,
                        'length' => 10,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jabatan',
                        'type'   => FieldType::CHAR,
                        'length' => 50,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Stat',
                        'type'   => FieldType::CHAR,
                        'length' => 10,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Ptkp_bln',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Ptkp',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jml_bln',
                        'type'   => FieldType::NUMERIC,
                        'length' => 5,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Dari',
                        'type'   => FieldType::CHAR,
                        'length' => 8,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Sampai',
                        'type'   => FieldType::CHAR,
                        'length' => 8,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Totalgross',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Natura',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Lembur',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'T_pajak',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jht_perush',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jp_perush',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jht',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jp',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Pph21',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Grosssalar',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Thr',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Pajak',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Bonusjul',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Pjk_jul',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Bonusdes',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Pjk_des',
                        'type'   => FieldType::CHAR,
                        'length' => 25,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Bnsthr',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Pajakbns',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Gaji_bnsth',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Astek_kary',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jpensiun',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jht_perusa',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Jp_perusah',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Total_aste',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tax_gaji',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tak_bnsthr',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tax_kary',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Taxplus',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tot_bayar',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col10',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col11',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col10_col1',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col12',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col13',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col14',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col16_tahu',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col17_ptkp',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col18_pkp',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Col19_ppht',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Terutang',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Tax_bayar',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Kurang',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->addColumn(new Column([
                        'name'   => 'Lebih',
                        'type'   => FieldType::NUMERIC,
                        'length' => 15,
                    ]))
                    ->save(); // Menyimpan tabel DBF
    
                // Menambahkan data ke dalam tabel DBF menggunakan TableEditor
                $table = new TableEditor($filepath, [
                    'editMode' => TableEditor::EDIT_MODE_CLONE, // atau mode lainnya yang sesuai
                ]);
    
                // Menambahkan setiap baris data
                foreach ($data as $row) {
                    // Menambahkan data baru dengan appendRecord
                    $record = $table->appendRecord();
                    $record->set('No', $row[0] ?? '');
                    $record->set('Nik', $row[1] ?? '');
                    $record->set('Nama', $row[2] ?? '');
                    $record->set('Sex', $row[3] ?? '');
                    $record->set('Gol', $row[4] ?? '');
                    $record->set('Dept', $row[5] ?? '');
                    $record->set('Sect', $row[6] ?? '');
                    $record->set('Tgl_masuk', $row[7] ?? '');
                    $record->set('Npwp', $row[8] ?? '');
                    $record->set('Stat_seksi', $row[9] ?? '');
                    $record->set('Jabatan', $row[10] ?? '');
                    $record->set('Stat', $row[11] ?? '');
                    $record->set('Ptkp_bln', $row[12] ?? '');
                    $record->set('Ptkp', $row[13] ?? '');
                    $record->set('Jml_bln', $row[14] ?? '');
                    $record->set('Dari', $row[15] ?? '');
                    $record->set('Sampai', $row[16] ?? '');
                    $record->set('Totalgross', $row[17] ?? '');
                    $record->set('Natura', $row[18] ?? '');
                    $record->set('Lembur', $row[19] ?? '');
                    $record->set('T_pajak', $row[20] ?? '');
                    $record->set('Jht_perush', $row[21] ?? '');
                    $record->set('Jp_perush', $row[22] ?? '');
                    $record->set('Jht', $row[23] ?? '');
                    $record->set('Jp', $row[24] ?? '');
                    $record->set('Pph21', $row[25] ?? '');
                    $record->set('Grosssalar', $row[26] ?? '');
                    $record->set('Thr', $row[27] ?? '');
                    $record->set('Pajak', $row[28] ?? '');
                    $record->set('Bonusjul', $row[29] ?? '');
                    $record->set('Pjk_jul', $row[30] ?? '');
                    $record->set('Bonusdes', $row[31] ?? '');
                    $record->set('Pjk_des', $row[32] ?? '');
                    $record->set('Bnsthr', $row[33] ?? '');
                    $record->set('Pajakbns', $row[34] ?? '');
                    $record->set('Gaji_bnsth', $row[35] ?? '');
                    $record->set('Astek_kary', $row[36] ?? '');
                    $record->set('Jpensiun', $row[37] ?? '');
                    $record->set('Jht_perusa', $row[38] ?? '');
                    $record->set('Jp_perusah', $row[39] ?? '');
                    $record->set('Total_aste', $row[40] ?? '');
                    $record->set('Tax_gaji', $row[41] ?? '');
                    $record->set('Tak_bnsthr', $row[42] ?? '');
                    $record->set('Tax_kary', $row[43] ?? '');
                    $record->set('Taxplus', $row[44] ?? '');
                    $record->set('Tot_bayar', $row[45] ?? '');
                    $record->set('Col10', $row[46] ?? '');
                    $record->set('Col11', $row[47] ?? '');
                    $record->set('Col10_col1', $row[48] ?? '');
                    $record->set('Col12', $row[49] ?? '');
                    $record->set('Col13', $row[50] ?? '');
                    $record->set('Col14', $row[51] ?? '');
                    $record->set('Col16_tahu', $row[52] ?? '');
                    $record->set('Col17_ptkp', $row[53] ?? '');
                    $record->set('Col18_pkp', $row[54] ?? '');
                    $record->set('Col19_ppht', $row[55] ?? '');
                    $record->set('Terutang', $row[56] ?? '');
                    $record->set('Tax_bayar', $row[57] ?? '');
                    $record->set('Kurang', $row[58] ?? '');
                    $record->set('Lebih', $row[59] ?? '');
    
                    // Menulis record ke dalam file DBF
                    $table->writeRecord();
                }
    
                // Menyimpan perubahan dan menutup tabel
                $table->save()->close();
    
                // Hapus file yang diupload
                unlink($uploadFile);
                $name = "gaji".(date('Y')-1)."_pjk.dbf";
                // Set header untuk file download
                header('Content-Type: application/dbf');
                header('Content-Disposition: attachment; filename="'.$name.'"');
                header('Content-Length: ' . filesize($filepath));
    
                // Baca file DBF dan kirim ke output buffer (browser)
                readfile($filepath);
    
                // Hapus file sementara setelah download selesai
                unlink($filepath);
            } catch (\Exception $e) {
                die("Error: " . $e->getMessage());
            }
        } else {
            die("File tidak ditemukan atau error saat upload.");
        }
    }

    public function index(Request $request)
    {
        return $request;
    }
}

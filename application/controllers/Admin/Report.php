<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;

class Report extends CI_Controller
{
    public function __construct(Type $var = null) {
        parent::__construct();
        $this->load->model(["M_login", "M_notif", "M_infoweb", "M_menu", "M_report"]);
        if(empty($this->session->userdata('username'))) {
            redirect(base_url('admin/login'));
        }
    }

    public function index() {
        $data['title_page'] = "Report Toko - Buboo Coffee";
        $data['judul'] = "Report";
        $data['back_url'] = base_url('admin');
        $this->load->view('admin/structure/V_head', $data);
        $this->load->view('admin/structure/V_topbar');
        $this->load->view('admin/structure/V_sidebar');
		$this->load->view('admin/V_report');
        $this->load->view('admin/structure/V_foot');
    }

    public function export_omset_per_hari() {
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $start = $date_start." 00:00:00";
        $end = $date_end." 23:59:59";
        $get_omset_per_hari = $this->M_report->getOmsetPerHari($start, $end);

        $existingFilePath = "./assets/temp-excel/Omset per Hari.xlsx";
        $newFilePath = "./assets/temp-excel/Omset per Hari.xlsx";
        
        if (file_exists($existingFilePath)) { 
            unlink($existingFilePath);
        }
        $link_result = base_url()."assets/temp-excel/Omset per Hari.xlsx";

        $sum_total_omset = 0; 
        if (file_exists($existingFilePath)) { 
            $reader = ReaderEntityFactory::createReaderFromFile($existingFilePath);
            $reader->setShouldFormatDates(true); 
            $reader->open($existingFilePath);
    
            $writer = WriterEntityFactory::createWriterFromFile($newFilePath);
            $writer->openToFile($newFilePath);
            $commonStyle =  (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
                if ($sheetIndex !== 1) {
                    $writer->addNewSheetAndMakeItCurrent();
                }
    
                foreach ($sheet->getRowIterator() as $row) {
                    $writer->addRow($row);
                }
            }
    
            $plunck_data = [];
            foreach ($get_omset_per_hari as $key => $row) {
                $cells = [
                    WriterEntityFactory::createCell(date("d/m/Y", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell((int) $row['total_order'], $styleNumber),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
    
                $sum_total_omset += $row['total_order'];
            }

            $cells = [
                WriterEntityFactory::createCell(""),
                WriterEntityFactory::createCell((int) $sum_total_omset, $styleNumber),
            ];
            $plunck_data[] = WriterEntityFactory::createRow($cells);
            $writer->addRows($plunck_data); 
    
            $reader->close();
            $writer->close();
            unlink($existingFilePath);
            rename($newFilePath, $existingFilePath);
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            $filePath = $existingFilePath;
    
            $writer->openToFile($filePath);
    
            $sheet = $writer->getCurrentSheet();
            $sheet->setName('Omset Harian');
            $style = (new StyleBuilder())
            ->setFontBold()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setFontName('Trebuchet MS')
            ->setFontSize(10)
            ->build();
    
            $commonStyle = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            $styleNumberFooter = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontBold()
            ->setFontName('Trebuchet MS')
            ->setFontColor(Color::RED)
            ->setFormat('#,##0')->build();
    
            //title of document
            $title = ['Tanggal', 'Omset'];
            $row = WriterEntityFactory::createRowFromArray($title, $style);
            $writer->addRow($row);

            $plunck_data = [];
            foreach ($get_omset_per_hari as $key => $row) {
                $cells = [
                    WriterEntityFactory::createCell(date("d/m/Y", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell((int) $row['total_order'], $styleNumber),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
    
                $sum_total_omset += $row['total_order'];
            }
            $cells = [
                WriterEntityFactory::createCell("Total", $commonStyle),
                WriterEntityFactory::createCell((int) $sum_total_omset, $styleNumber),
            ];
            $plunck_data[] = WriterEntityFactory::createRow($cells);
            $writer->addRows($plunck_data); 
            $writer->close();
        }

        $response = array(
            'status' => true,
            'link' => $link_result,
        );
    
        echo json_encode($response);
    }


    public function export_data_order() {
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $start = $date_start." 00:00:00";
        $end = $date_end." 23:59:59";
        $get_data_order = $this->M_report->getDataOrder($start, $end);

        $existingFilePath = "./assets/temp-excel/Data Order.xlsx";
        $newFilePath = "./assets/temp-excel/Data Order.xlsx";
        
        if (file_exists($existingFilePath)) { 
            unlink($existingFilePath);
        }
        $link_result = base_url()."assets/temp-excel/Data Order.xlsx";

        $sum_total_omset = 0; 
        if (file_exists($existingFilePath)) { 
            $reader = ReaderEntityFactory::createReaderFromFile($existingFilePath);
            $reader->setShouldFormatDates(true); 
            $reader->open($existingFilePath);
    
            $writer = WriterEntityFactory::createWriterFromFile($newFilePath);
            $writer->openToFile($newFilePath);
            $commonStyle =  (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
                if ($sheetIndex !== 1) {
                    $writer->addNewSheetAndMakeItCurrent();
                }
    
                foreach ($sheet->getRowIterator() as $row) {
                    $writer->addRow($row);
                }
            }
    
            $plunck_data = [];
            foreach ($get_data_order as $key => $row) {
                $cells = [
                    WriterEntityFactory::createCell((int) $row['id_order'], $styleNumber),
                    WriterEntityFactory::createCell($row['no_pesanan'], $commonStyle),
                    WriterEntityFactory::createCell(date("d/m/Y H:i", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell($row['nama_customer'], $commonStyle),
                    WriterEntityFactory::createCell($row['no_hp'], $commonStyle),
                    WriterEntityFactory::createCell((int) $row['total_order'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['diskon'], $styleNumber),
                    WriterEntityFactory::createCell($row['judul_voucher'], $commonStyle),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
            }
            $writer->addRows($plunck_data); 
    
            $reader->close();
            $writer->close();
            unlink($existingFilePath);
            rename($newFilePath, $existingFilePath);
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            $filePath = $existingFilePath;
    
            $writer->openToFile($filePath);
    
            $sheet = $writer->getCurrentSheet();
            $sheet->setName('Data Order');
            $style = (new StyleBuilder())
            ->setFontBold()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setFontName('Trebuchet MS')
            ->setFontSize(10)
            ->build();
    
            $commonStyle = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            $styleNumberFooter = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontBold()
            ->setFontName('Trebuchet MS')
            ->setFontColor(Color::RED)
            ->setFormat('#,##0')->build();
    
            //title of document
            $title = ['ID Order', 'No. Pesanan', "Tanggal Order", "Nama Pelanggan", "No. HP", "Total Order", "Diskon", "Keterangan Promo"];
            $row = WriterEntityFactory::createRowFromArray($title, $style);
            $writer->addRow($row);

            $plunck_data = [];
            foreach ($get_data_order as $key => $row) {
                $cells = [
                    WriterEntityFactory::createCell((int) $row['id_order'], $styleNumber),
                    WriterEntityFactory::createCell($row['no_pesanan'], $commonStyle),
                    WriterEntityFactory::createCell(date("d/m/Y H:i", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell($row['nama_customer'], $commonStyle),
                    WriterEntityFactory::createCell($row['no_hp'], $commonStyle),
                    WriterEntityFactory::createCell((int) $row['total_order'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['diskon'], $styleNumber),
                    WriterEntityFactory::createCell($row['judul_voucher'], $commonStyle),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
            }
            $writer->addRows($plunck_data); 
            $writer->close();
        }

        $response = array(
            'status' => true,
            'link' => $link_result,
        );
    
        echo json_encode($response);
    }

    public function export_menu_terjual() {
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $start = $date_start." 00:00:00";
        $end = $date_end." 23:59:59";
        $get_detail_order = $this->M_report->getDetailOrder($start, $end);

        $existingFilePath = "./assets/temp-excel/Menu Terjual.xlsx";
        $newFilePath = "./assets/temp-excel/Menu Terjual.xlsx";
        
        if (file_exists($existingFilePath)) { 
            unlink($existingFilePath);
        }
        $link_result = base_url()."assets/temp-excel/Menu Terjual.xlsx";

        $sum_total_omset = 0; 
        if (file_exists($existingFilePath)) { 
            $reader = ReaderEntityFactory::createReaderFromFile($existingFilePath);
            $reader->setShouldFormatDates(true); 
            $reader->open($existingFilePath);
    
            $writer = WriterEntityFactory::createWriterFromFile($newFilePath);
            $writer->openToFile($newFilePath);
            $commonStyle =  (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
                if ($sheetIndex !== 1) {
                    $writer->addNewSheetAndMakeItCurrent();
                }
    
                foreach ($sheet->getRowIterator() as $row) {
                    $writer->addRow($row);
                }
            }
    
            $plunck_data = [];
            foreach ($get_detail_order as $key => $row) {
                $judul_voucher = "";
                if (!empty($row['keterangan']) || $row['potongan'] > 0) {
                    $judul_voucher = $row['judul_voucher'];
                }
                $cells = [
                    WriterEntityFactory::createCell((int) $row['id_order'], $styleNumber),
                    WriterEntityFactory::createCell($row['no_pesanan'], $commonStyle),
                    WriterEntityFactory::createCell(date("d/m/Y H:i", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell($row['nama_menu'], $commonStyle),
                    WriterEntityFactory::createCell($row['nama_kategori'], $commonStyle),
                    WriterEntityFactory::createCell((int) $row['quantity'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['harga'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['potongan'], $styleNumber),
                    WriterEntityFactory::createCell($row['keterangan'], $commonStyle),
                    WriterEntityFactory::createCell($judul_voucher, $commonStyle),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
            }
            $writer->addRows($plunck_data); 
    
            $reader->close();
            $writer->close();
            unlink($existingFilePath);
            rename($newFilePath, $existingFilePath);
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            $filePath = $existingFilePath;
    
            $writer->openToFile($filePath);
    
            $sheet = $writer->getCurrentSheet();
            $sheet->setName('Data Order');
            $style = (new StyleBuilder())
            ->setFontBold()
            ->setCellAlignment(CellAlignment::CENTER)
            ->setFontName('Trebuchet MS')
            ->setFontSize(10)
            ->build();
    
            $commonStyle = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')->build();
            $styleNumber = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontName('Trebuchet MS')
            ->setFormat('#,##0')->build();
    
            $styleNumberFooter = (new StyleBuilder())
            ->setFontSize(10)
            ->setFontBold()
            ->setFontName('Trebuchet MS')
            ->setFontColor(Color::RED)
            ->setFormat('#,##0')->build();
    
            //title of document
            $title = ['ID Order', 'No. Pesanan', "Tanggal Order", "Nama Menu", "Nama Kategori", "Quantity", "Harga", "Potongan", "Keterangan", "Nama Promo"];
            $row = WriterEntityFactory::createRowFromArray($title, $style);
            $writer->addRow($row);

            $plunck_data = [];
            foreach ($get_detail_order as $key => $row) {
                $judul_voucher = "";
                if (!empty($row['keterangan']) || $row['potongan'] > 0) {
                    $judul_voucher = $row['judul_voucher'];
                }
                $cells = [
                    WriterEntityFactory::createCell((int) $row['id_order'], $styleNumber),
                    WriterEntityFactory::createCell($row['no_pesanan'], $commonStyle),
                    WriterEntityFactory::createCell(date("d/m/Y H:i", strtotime($row['datetime_order'])), $commonStyle),
                    WriterEntityFactory::createCell($row['nama_menu'], $commonStyle),
                    WriterEntityFactory::createCell($row['nama_kategori'], $commonStyle),
                    WriterEntityFactory::createCell((int) $row['quantity'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['harga'], $styleNumber),
                    WriterEntityFactory::createCell((int) $row['potongan'], $styleNumber),
                    WriterEntityFactory::createCell($row['keterangan'], $commonStyle),
                    WriterEntityFactory::createCell($judul_voucher, $commonStyle),
                ];
                $plunck_data[] = WriterEntityFactory::createRow($cells);
            }
            $writer->addRows($plunck_data); 
            $writer->close();
        }

        $response = array(
            'status' => true,
            'link' => $link_result,
        );
    
        echo json_encode($response);
    }

    function zip_report() {
        $filePath = './assets/temp-excel/';
        $link_result = base_url()."assets/temp-excel/";
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $zip_name = $date_start." sd ".$date_end.".zip";

        if (file_exists($filePath.$zip_name)) { 
            unlink($filePath.$zip_name);
        }
        $zip = new ZipArchive;
        if ($zip->open($filePath.$zip_name, ZipArchive::CREATE) === TRUE) {
            if ($handle = opendir($filePath)){
                while (false !== ($entry = readdir($handle))){
                    if ($entry != "." && $entry != ".." && !is_dir($filePath . $entry)){
                        $file_parts = pathinfo($filePath . $entry);
                        if ($file_parts['extension'] != "zip") {
                            $zip->addFile($filePath.$entry, $entry);
                        } else {
                            continue;
                        }
                    }
                }
                closedir($handle);
            }
            $zip->close();
    
            $response = array('status' => true, 'message' => "Success Create Zip", 'link' => $link_result.$zip_name);
        } else {
            $response = array('status' => false, 'message' => "Failed Create Zip", 'link' => null);
        }
        echo json_encode($response);
    }


}
<?php
namespace common\models\export_excel;
/**
 * @property \PHPExcel $objPHPExcel
 */

use backend\models\ChiTietCongVanDen;
use backend\models\DonVi;
use common\models\formatExcel;
use common\models\myAPI;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;

/**
 * @author Nikola Kostadinov
 * @license MIT License
 * @version 0.3
 * @link http://yiiframework.com/extension/eexcelview/
 *
 * @fork 0.33ab
 * @forkversion 1.1
 * @author A. Bennouna
 * @organization tellibus.com
 * @license MIT License
 * @link https://github.com/tellibus/tlbExcelView
 */

/* Usage :
  $this->widget('application.components.widgets.tlbExcelView', array(
    'id'                   => 'some-grid',
    'dataProvider'         => $model->search(),
    'grid_mode'            => $production, // Same usage as EExcelView v0.33
    //'template'           => "{summary}\n{items}\n{exportbuttons}\n{pager}",
    'title'                => 'Some title - ' . date('d-m-Y - H-i-s'),
    'creator'              => 'Your Name',
    'subject'              => mb_convert_encoding('Something important with a date in French: ' . utf8_encode(strftime('%e %B %Y')), 'ISO-8859-1', 'UTF-8'),
    'description'          => mb_convert_encoding('Etat de production généré à la demande par l\'administrateur (some text in French).', 'ISO-8859-1', 'UTF-8'),
    'lastModifiedBy'       => 'Some Name',
    'sheetTitle'           => 'Report on ' . date('m-d-Y H-i'),
    'keywords'             => '',
    'category'             => '',
    'landscapeDisplay'     => true, // Default: false
    'A4'                   => true, // Default: false - ie : Letter (PHPExcel default)
    'RTL'                  => false, // Default: false
    'pageFooterText'       => '&RThis is page no. &P of &N pages', // Default: '&RPage &P of &N'
    'automaticSum'         => true, // Default: false
    'decimalSeparator'     => ',', // Default: '.'
    'thousandsSeparator'   => '.', // Default: ','
    //'displayZeros'       => false,
    //'zeroPlaceholder'    => '-',
    'sumLabel'             => 'Column totals:', // Default: 'Totals'
    'borderColor'          => '00FF00', // Default: '000000'
    'bgColor'              => 'FFFF00', // Default: 'FFFFFF'
    'textColor'            => 'FF0000', // Default: '000000'
    'rowHeight'            => 45, // Default: 15
    'headerBorderColor'    => 'FF0000', // Default: '000000'
    'headerBgColor'        => 'CCCCCC', // Default: 'CCCCCC'
    'headerTextColor'      => '0000FF', // Default: '000000'
    'headerHeight'         => 10, // Default: 20
    'footerBorderColor'    => '0000FF', // Default: '000000'
    'footerBgColor'        => '00FFCC', // Default: 'FFFFCC'
    'footerTextColor'      => 'FF00FF', // Default: '0000FF'
    'footerHeight'         => 50, // Default: 20
    'columns'              => $grid // an array of your CGridColumns
)); */

class BaoCaoRaSoat
{
    public $thoi_gian_tu;
    public $thoi_gian_den;
    public $path_file;
    public $da_hoan_thanh_dung_han;
    public $chua_hoan_thanh_trong_han;

//    public $thoigianthongke_tu;
//    public $thoigianthongke_den;

    public $data;
    public $maxColumn = 23;
    public $headerFile;
    //Document properties
    public $creator = 'VISHIPEL';
    public $title = 'BAO CAO RA SOAT CVD';
    public $subject = 'BAO CAO RA SOAT CVD';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'VISHIPEL';
    public $keywords = '';
    public $sheetTitle = 'BAO CAO RA SOAT CVD';
    public $legal = 'BAO CAO RA SOAT CVD';
    public $landscapeDisplay = false;
    public $A4 = false;
    public $RTL = false;
    public $pageFooterText = '&RPage &P of &N';

    //config
    public $autoWidth = true;
    public $exportType = 'Excel2007';
    public $disablePaging = true;
    public $filename = null; //export FileName
    public $stream = true; //stream to browser
    public $grid_mode = 'export'; //Whether to display grid ot export it to selected format. Possible values(grid, export)
    public $grid_mode_var = 'grid_mode'; //GET var for the grid mode

    //options
    public $automaticSum = false;
    public $sumLabel = 'Totals';
    public $decimalSeparator = '.';
    public $thousandsSeparator = ',';
    public $displayZeros = false;
    public $zeroPlaceholder = '-';
    public $border_style;
    public $borderColor = '000000';
    public $bgColor = 'FFFFFF';
    public $textColor = '000000';
    public $rowHeight = 15;
    public $headerBorderColor = '000000';
    public $headerBgColor = 'CCCCCC';
    public $headerTextColor = '000000';
    public $headerHeight = 20;
    public $footerBorderColor = '000000';
    public $footerBgColor = 'FFFFCC';
    public $footerTextColor = '0000FF';
    public $footerHeight = 20;
    public static $fill_solid;
    public static $papersize_A4;
    public static $orientation_landscape;
    public static $horizontal_center;
    public static $horizontal_right;
    public static $vertical_center;
    public static $horizontal_left;
    public static $style = array();
    public static $headerStyle = array();
    public static $footerStyle = array();
    public static $summableColumns = array();

    public static $objPHPExcel;
    public static $activeSheet;

    //buttons config
    public $exportButtonsCSS = 'summary';
    public $exportButtons = array('Excel2007');
    public $exportText = 'Export to: ';

    //callbacks
    public $onRenderHeaderCell = null;
    public $onRenderDataCell = null;
    public $onRenderFooterCell = null;

    //mime types used for streaming
    public $mimeTypes = array(
        'Excel5'	=> array(
            'Content-type'=>'application/vnd.ms-excel',
            'extension'=>'xls',
            'caption'=>'Excel(*.xls)',
        ),
        'Excel2007'	=> array(
            'Content-type'=>'application/vnd.ms-excel',
            'extension'=>'xlsx',
            'caption'=>'Excel(*.xlsx)',
        ),
        'PDF'		=>array(
            'Content-type'=>'application/pdf',
            'extension'=>'pdf',
            'caption'=>'PDF(*.pdf)',
        ),
        'HTML'		=>array(
            'Content-type'=>'text/html',
            'extension'=>'html',
            'caption'=>'HTML(*.html)',
        ),
        'CSV'		=>array(
            'Content-type'=>'application/csv',
            'extension'=>'csv',
            'caption'=>'CSV(*.csv)',
        )
    );

    public function init()
    {
//        PHPExcel_Worksheet_PageSetup
        self::$papersize_A4 = \PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4;
        self::$orientation_landscape = \PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE;
        self::$fill_solid = \PHPExcel_Style_Fill::FILL_SOLID;
        if (!isset($this->border_style)) {
            $this->border_style = \PHPExcel_Style_Border::BORDER_THIN;
        }
        self::$horizontal_center = \PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        self::$horizontal_right = \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
        self::$horizontal_left = \PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
        self::$vertical_center = \PHPExcel_Style_Alignment::VERTICAL_CENTER;

        // Creating a workbook
        self::$objPHPExcel = new \PHPExcel();
        self::$objPHPExcel->createSheet()->setTitle("BAO CAO RA SOAT CVD");
        self::$objPHPExcel->setActiveSheetIndexByName("BAO CAO RA SOAT CVD");
        self::$activeSheet = self::$objPHPExcel->getActiveSheet();

        // Set some basic document properties
        if ($this->landscapeDisplay) {
            self::$activeSheet->getPageSetup()->setOrientation(self::$orientation_landscape);
        }

        if ($this->A4) {
            self::$activeSheet->getPageSetup()->setPaperSize(self::$papersize_A4);
        }

        if ($this->RTL) {
            self::$activeSheet->setRightToLeft(true);
        }

        self::$objPHPExcel->getProperties()
            ->setTitle($this->title)
            ->setCreator($this->creator)
            ->setSubject($this->subject)
            ->setDescription($this->description . ' // ' . $this->legal)
            ->setCategory($this->category)
            ->setLastModifiedBy($this->lastModifiedBy)
            ->setKeywords($this->keywords);

        // Initialize styles that will be used later
        self::$style = array(
            'borders' => array(
                'allborders' => array(
                    'style' => $this->border_style,
                    'color' => array('rgb' => $this->borderColor),
                ),
            ),
            'fill' => array(
                'type' => self::$fill_solid,
                'color' => array('rgb' => $this->bgColor),
            ),
            'font' => array(
                //'bold' => false,
                'color' => array('rgb' => $this->textColor),
            )
        );
        self::$headerStyle = array(
            'borders' => array(
                'allborders' => array(
                    'style' => $this->border_style,
                    'color' => array('rgb' => $this->headerBorderColor),
                ),
            ),
            'fill' => array(
                'type' => self::$fill_solid,
                'color' => array('rgb' => $this->headerBgColor),
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => $this->headerTextColor),
            )
        );
        self::$footerStyle = array(
            'borders' => array(
                'allborders' => array(
                    'style' => $this->border_style,
                    'color' => array('rgb' => $this->footerBorderColor),
                ),
            ),
            'fill' => array(
                'type' => self::$fill_solid,
                'color' => array('rgb' => $this->footerBgColor),
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => $this->footerTextColor),
            )
        );

        return self::$activeSheet;
    }

    /**
     * @param $objectPHPExcel \PHPExcel
     */
    public function renderSheetTongHop($objectPHPExcel){
        $activeSheet = $objectPHPExcel->setActiveSheetIndex(0);
        $activeSheet->setCellValue("A2", "BÁO CÁO TỔNG HỢP VIỆC THỰC HIỆN NHIỆM VỤ, KẾT LUẬN, CHỈ ĐẠO CỦA CẤP CÓ THẨM QUYỀN GIAO CHO SỞ NÔNG NGHIỆPVÀ PTNT TỪ NGÀY ".date("d/m/Y", strtotime($this->thoi_gian_tu))." ĐẾN ".date("d/m/Y", strtotime($this->thoi_gian_den)));

        $dong = 11;

        foreach ($this->data as $index => $item) {
            /** @var $item ChiTietCongVanDen */
            $activeSheet->setCellValue("A{$dong}", $index + 1);
            $activeSheet->setCellValue("B{$dong}", $item->don_vi_gui);
            $activeSheet->setCellValue("C{$dong}", $item->trichYeuNoiDung);

            if($item->phan_loai_don_vi_gui == DonVi::TTCP)
                $activeSheet->setCellValue("D{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::TT_TINH_UY)
                $activeSheet->setCellValue("E{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::HDND_TINH)
                $activeSheet->setCellValue("F{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::UBND_TINH)
                $activeSheet->setCellValue("G{$dong}", "x");

            $activeSheet->setCellValue("H{$dong}", $item->soDen);
            if($item->ngayDen!=''){
                $arr_ngay = explode('-',$item->ngayDen);
                $activeSheet->setCellValue("I{$dong}", $arr_ngay[2]);
                $activeSheet->setCellValue("J{$dong}", $arr_ngay[1]);
                $activeSheet->setCellValue("K{$dong}", $arr_ngay[0]);
            }
            if($item->hanThucHien != '')
                $activeSheet->setCellValue("L{$dong}", $item->hanThucHien);
            else
                $activeSheet->setCellValue("L{$dong}", "Ko hạn");


            $arr_so_di = explode('/', $item->soDi);
            if(count($arr_so_di) > 0){
                $activeSheet->setCellValue("S{$dong}", $arr_so_di[0]);
                if($item->ngayCongVanCoHieuLuc != ""){
                    $arr_ngay_dang_cong_van_di = explode('-', $item->ngayDangCongVan);
                    $activeSheet->setCellValue("T{$dong}", $arr_ngay_dang_cong_van_di[2]);
                    $activeSheet->setCellValue("U{$dong}", $arr_ngay_dang_cong_van_di[1]);
                    $activeSheet->setCellValue("V{$dong}", $arr_ngay_dang_cong_van_di[0]);
                }
            }


            if($item->da_hoan_thanh){

                $so_ngay_hoan_thanh = myAPI::tinhSoNgay($item->hanThucHien, $item->ngay_hoan_thanh);
                if($item->hanThucHien == '' || $so_ngay_hoan_thanh == 0){
                    $activeSheet->setCellValue("M{$dong}", "x");
                    $this->da_hoan_thanh_dung_han[] = $item;
                }
                if($so_ngay_hoan_thanh <= 7)
                    $activeSheet->setCellValue("N{$dong}", "x");
                else
                    $activeSheet->setCellValue("O{$dong}", "x");

            }else{
                $so_ngay_qua_han = myAPI::tinhSoNgay($item->hanThucHien, date("Y-m-d"));
                if($so_ngay_qua_han == 0){
                    $activeSheet->setCellValue("P{$dong}", "x");
                    $this->chua_hoan_thanh_trong_han[] = $item;
                }
                else if($so_ngay_qua_han <= 7)
                    $activeSheet->setCellValue("Q{$dong}", "x");
                else
                    $activeSheet->setCellValue("R{$dong}", "x");
            }
            $activeSheet->setCellValue("W{$dong}", $item->danh_gia == "" ? $item->danh_gia_khac : $item->danh_gia);
            $activeSheet->setCellValue("X{$dong}", str_replace(",","\n",$item->donvithuchien));
            $dong++;
        }
        $dong--;
        formatExcel::setBorder($activeSheet, "A5:X{$dong}");
    }

    /**
     * @param $objctPHPExcel \PHPExcel
     */
    public function renderSheetHoanThanhDungHan($objctPHPExcel){
        $activeSheet = $objctPHPExcel->setActiveSheetIndex(1);
        $activeSheet->setCellValue("A2", "BÁO CÁO TỔNG HỢP VIỆC THỰC HIỆN NHIỆM VỤ, KẾT LUẬN, CHỈ ĐẠO CỦA CẤP CÓ THẨM QUYỀN GIAO CHO SỞ NÔNG NGHIỆPVÀ PTNT TỪ NGÀY ".date("d/m/Y", strtotime($this->thoi_gian_tu))." ĐẾN ".date("d/m/Y", strtotime($this->thoi_gian_den)));
        $dong = 12;
        if(count($this->da_hoan_thanh_dung_han) > 0)
        foreach ($this->da_hoan_thanh_dung_han as $index => $item) {
            /** @var $item ChiTietCongVanDen */
            $activeSheet->setCellValue("A{$dong}", $index + 1);
            $activeSheet->setCellValue("B{$dong}", $item->don_vi_gui);
            $activeSheet->setCellValue("C{$dong}", $item->trichYeuNoiDung);

            if($item->phan_loai_don_vi_gui == DonVi::TTCP)
                $activeSheet->setCellValue("D{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::TT_TINH_UY)
                $activeSheet->setCellValue("E{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::HDND_TINH)
                $activeSheet->setCellValue("F{$dong}", "x");
            elseif($item->phan_loai_don_vi_gui == DonVi::UBND_TINH)
                $activeSheet->setCellValue("G{$dong}", "x");

            $activeSheet->setCellValue("H{$dong}", $item->soDen);
            if($item->ngayDen!=''){
                $arr_ngay = explode('-',$item->ngayDen);
                $activeSheet->setCellValue("I{$dong}", $arr_ngay[2]);
                $activeSheet->setCellValue("J{$dong}", $arr_ngay[1]);
                $activeSheet->setCellValue("K{$dong}", $arr_ngay[0]);
            }
            if($item->hanThucHien != '')
                $activeSheet->setCellValue("L{$dong}", $item->hanThucHien);
            else
                $activeSheet->setCellValue("L{$dong}", "Ko hạn");

            if($item->da_hoan_thanh){

                $so_ngay_hoan_thanh = myAPI::tinhSoNgay($item->hanThucHien, $item->ngay_hoan_thanh);
                if($item->hanThucHien == '' || $so_ngay_hoan_thanh == 0){
                    $activeSheet->setCellValue("M{$dong}", "x");
                    $this->da_hoan_thanh_dung_han[] = $item;
                }
            }
            $activeSheet->setCellValue("W{$dong}", $item->danh_gia == "" ? $item->danh_gia_khac : $item->danh_gia);
            $activeSheet->setCellValue("X{$dong}", str_replace(",","\n",$item->donvithuchien));
            $dong++;
        }
        $dong--;
        formatExcel::setBorder($activeSheet, "A6:X{$dong}");
    }

    public function run()
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');

        $objPHPExcel = $objReader->load(dirname(dirname(dirname(__DIR__))).'/common/template/MAU_BCKQ_RA_SOAT.xlsx');
        $this->renderSheetTongHop($objPHPExcel);
//        $this->renderSheetHoanThanhDungHan($objPHPExcel);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $this->exportType);
        $this->filename = 'BAO_CAO_RA_SOAT_TU_'.myAPI::createCode($this->thoi_gian_tu).'_DEN_'.myAPI::createCode($this->thoi_gian_den).'.xlsx';

        if (!$this->stream) {
            $objWriter->save($this->path_file.$this->filename);
        } else {
            //output to browser
            if(!$this->filename) {
                $this->filename = $this->title;
            }
            $this->cleanOutput();
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: '.$this->mimeTypes[$this->exportType]['Content-type']);
            header('Content-Disposition: attachment; filename="' . $this->filename . '.' . $this->mimeTypes[$this->exportType]['extension'] . '"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            exit;
        }
        return $this->filename;
    }

    /**
     * Returns the corresponding Excel column.(Abdul Rehman from yii forum)
     *
     * @param int $index
     * @return string
     */
    public function columnName($index)
    {
        --$index;
        if (($index >= 0) && ($index < 26)) {
            return chr(ord('A') + $index);
        } else if ($index > 25) {
            return ($this->columnName($index / 26)) . ($this->columnName($index%26 + 1));
        } else {
            throw new Exception("Invalid Column # " . ($index + 1));
        }
    }

    /**
     * Performs cleaning on mutliple levels.
     *
     * From le_top @ yiiframework.com
     *
     */
    private static function cleanOutput()
    {
        for ($level = ob_get_level(); $level > 0; --$level) {
            @ob_end_clean();
        }
    }
}
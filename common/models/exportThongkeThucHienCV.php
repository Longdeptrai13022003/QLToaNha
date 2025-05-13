<?php
namespace common\models;
/**
 * @property \PHPExcel $objPHPExcel
 */
use backend\models\CauHoi;
use yii\base\Exception;
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

class exportThongkeThucHienCV
{
    public $tieu_de;
    public $thoi_gian;
    public $data;
    public $data_7_ngay_toi;
    public $phong_ban;

    public $endColumn;
    public $headerFile;
    //Document properties
    public $creator = 'MINH HIEN SETE.,CO.LTD';
    public $title = 'THONG KE THUC HIEN CVT';
    public $subject = 'THONG KE THUC HIEN CVT';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'MINH HIEN SETE.,CO.LTD';
    public $keywords = '';
    public $sheetTitle = 'THONG KE THUC HIEN CVT';
    public $legal = 'THONG KE THUC HIEN CVT';
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
            'Content-type'=>'applicationVND/.ms-excel',
            'extension'=>'xls',
            'caption'=>'Excel(*.xls)',
        ),
        'Excel2007'	=> array(
            'Content-type'=>'applicationVND/.ms-excel',
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
        self::$objPHPExcel->createSheet()->setTitle("THONG KE THUC HIEN CVT");
        self::$objPHPExcel->setActiveSheetIndexByName("THONG KE THUC HIEN CVT");
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


    public function renderData($activeSheet, $data, $dong, $index){
        foreach ($data as $idThucHienCongViec => $item) {
            $activeSheet->setCellValue("A{$dong}", $index + 1);
            $index++;
            $activeSheet->setCellValue("B{$dong}", str_replace('<br/>', "\n", $item['tieu_de']));
            $activeSheet->setCellValue("C{$dong}", implode("\n",$item['cong_viec_muc_tieu']));
            $activeSheet->setCellValue("D{$dong}", implode(' đến ', [$item['from'], $item['to']]));
            $activeSheet->setCellValue("E{$dong}", str_replace('<br/>', "\n", $item['trang_thai']));
            $activeSheet->setCellValue("F{$dong}", str_replace('<br/>', "\n", $item['ghi_chu_trang_thai']));
            $dong++;
        }
        return $dong;
    }

    /**
     * @param $activeSheet \PHPExcel_Worksheet
     */
    public function renderBody($activeSheet){
        $activeSheet->setCellValue("A1", $this->tieu_de);
        $activeSheet->setCellValue("A2", $this->thoi_gian);
        $dong = 5;
        $index = 0;
        $dong = $this->renderData($activeSheet, $this->data, $dong, $index);
        $dong--;
        formatExcel::setBorder($activeSheet, "A4:F{$dong}");

        $dong++;
        $activeSheet->setCellValue("A{$dong}", 'II. CÔNG VIỆC TUẦN TỚI');
        $activeSheet->mergeCells("A{$dong}:F{$dong}");
        formatExcel::setFontBold($activeSheet, "A{$dong}");
        $dong++;
        $activeSheet->setCellValue("A{$dong}", "STT");
        $activeSheet->setCellValue("B{$dong}", "Nội dung đã thực hiện");
        $activeSheet->setCellValue("C{$dong}", "Công việc mục tiêu");
        $activeSheet->setCellValue("D{$dong}", "Thời gian thực hiện");
        $activeSheet->setCellValue("E{$dong}", "Trạng thái công việc");
        $activeSheet->setCellValue("F{$dong}", "Kết quả đạt được");
        $dong_dau = $dong;
        formatExcel::setFontBold($activeSheet, "A{$dong}:F{$dong}");
        $dong++;
        $index = 0;
        $dong = $this->renderData($activeSheet, $this->data_7_ngay_toi, $dong, $index);
        $dong--;
        formatExcel::setBorder($activeSheet, "A{$dong_dau}:F{$dong}");

    }

    public function run()
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load(dirname(dirname(__DIR__)).'/common/template/MAU_BAO_CAO_THCV.xlsx');
        $activeSheet = $objPHPExcel->getActiveSheet();
        $this->renderBody($activeSheet);
        $this->filename = 'Bao_cao_THCV_'.myAPI::createCode($this->phong_ban).'-'.time().'.xlsx';;
        $this->path_file.=$this->filename;
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $this->exportType);
        $objWriter->setPreCalculateFormulas(true);

        if (!$this->stream) {
            $objWriter->save($this->path_file);
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

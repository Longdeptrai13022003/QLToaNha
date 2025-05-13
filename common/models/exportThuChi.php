<?php
namespace common\models;
/**
 * @property \PHPExcel $objPHPExcel
 */

use backend\models\ChiTietTimeBooking;
use backend\models\DaiLy;
use backend\models\DanhMuc;
use backend\models\DonHang;
use backend\models\GiaoDich;
use backend\models\QuanLyDonHang;
use backend\models\QuanLyPhongKhach;
use backend\models\QuanLyThuChi;
use Faker\Provider\DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
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
class exportThuChi
{
    public $data;
    public $path_file;
    public $thang;
    public $nam;
    public $from_date;
    public $to_date;
    //Document properties
    public $creator = 'ANDIN JSC';
    public $title = 'Thống kê thu chi';
    public $subject = 'ANDIN JSC';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'ANDIN JSC';
    public $keywords = '';
    public $sheetTitle = 'Thống kê thu chi';
    public $legal = 'EBM';
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
    /**
     * @param $activeSheet Worksheet
     * @param $objPHPExcel IOFactory
     */
    public function renderBody($objPHPExcel){
        $data = $this->data;
        $fromDate = date("d/m/Y", strtotime($this->from_date));
        $toDate = date("d/m/Y", strtotime($this->to_date));
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheetNames = ['BC LÃI LỖ', 'HỢP ĐỒNG', 'HÓA ĐƠN', 'GIAO DỊCH', 'CÔNG NỢ', 'PHÒNG Ở', 'CHI PHÍ MÔI GIỚI', 'CHI PHÍ KHÁC'];
        foreach ($sheetNames as $sheetIndex => $sheetName) {
            $activeSheet = $objPHPExcel->setActiveSheetIndexByName($sheetName);
            $dong = 3;
            switch ($sheetName) {
                case 'BC LÃI LỖ':
                    $activeSheet->setCellValue("A1", "BÁO CÁO KẾT QUẢ HOẠT ĐỘNG KINH DOANH THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    $bao_cao_lai_lo = $data['bao_cao_lai_lo'];
                    $activeSheet->setCellValue("C3", $bao_cao_lai_lo['tong_thu']);
                    $activeSheet->setCellValue("C4", $bao_cao_lai_lo['tong_chi']);
                    $activeSheet->setCellValue("C5", $bao_cao_lai_lo['loi_nhuan']);
                    break;

                case 'HỢP ĐỒNG':
                    $dong++;
                    $hop_dongs = $data['hop_dong'];
                    $activeSheet->setCellValue("A1", "TỔNG HỢP HỢP ĐỒNG THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    foreach ($hop_dongs as $index => $item) {
                        $hienThiTu = \DateTime::createFromFormat('Y-m-d H:i:s', $item['thoi_gian_hop_dong_tu'])->format('d/m/Y');
                        $hienThi = \DateTime::createFromFormat('Y-m-d H:i:s', $item['thoi_gian_hop_dong_den'])->format('d/m/Y');

                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", 'Từ '.$hienThiTu.' đến '.$hienThi)
                            ->setCellValue("C{$dong}", $item['ma_hop_dong'])
                            ->setCellValue("D{$dong}", $item['hoten'] . '(' . $item['dien_thoai'] . ')')
                            ->setCellValue("E{$dong}", $item['hoten_sale'] != '' ? $item['hoten_sale'] . '(' . $item['dien_thoai_sale'] . ')' : '')
                            ->setCellValue("F{$dong}", $item['so_tien_moi_gioi'])
                            ->setCellValue("G{$dong}", $item['ten_phong'] .'/'.$item['ten_toa_nha'])
                            ->setCellValue("H{$dong}", $item['don_gia']);
                        $activeSheet->getStyle("A{$dong}:I{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;

                case 'HÓA ĐƠN':
                    $hoa_dons = $data['hoa_don'];
                    $activeSheet->setCellValue("A1", "TỔNG HỢP HÓA ĐƠN THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    foreach ($hoa_dons as $index => $item) {
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", date("d/m/Y", strtotime($item['created'])))
                            ->setCellValue("C{$dong}", $item['ma_hoa_don'])
                            ->setCellValue("D{$dong}", $item['ten_phong'] .'/'.$item['ten_toa_nha'])
                            ->setCellValue("E{$dong}", $item['hoten'] . '(' . $item['dien_thoai'] . ')')
                            ->setCellValue("F{$dong}", $item['trang_thai']);
                        $activeSheet->getStyle("A{$dong}:G{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;

                case 'GIAO DỊCH':
                    $giao_dichs = $data['giao_dich'];
                    foreach ($giao_dichs as $index => $item){
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", date("d/m/Y", strtotime($item['created'])))
                            ->setCellValue("C{$dong}", $item['ma_hop_dong'])
                            ->setCellValue("D{$dong}", $item['ma_hoa_don'])
                            ->setCellValue("E{$dong}", $item['ten_phong'] .'/'.$item['ten_toa_nha'])
                            ->setCellValue("F{$dong}", $item['hoten'] . '(' . $item['dien_thoai'] . ')')
                            ->setCellValue("G{$dong}", $item['tong_tien'])
                            ->setCellValue("H{$dong}", $item['trang_thai_giao_dich']);
                        $activeSheet->getStyle("A{$dong}:J{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;

                case 'CÔNG NỢ':
                    $activeSheet->setCellValue("A1", "BÁO CÁO CÔNG NỢ THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    $cong_nos = $data['cong_no'];
                    foreach ($cong_nos as $index => $item){
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", date("d/m/Y H:i:s", strtotime($item['created'])))
                            ->setCellValue("C{$dong}", $item['ma_hop_dong'])
                            ->setCellValue("D{$dong}", $item['ten_phong'] .'/'.$item['ten_toa_nha'])
                            ->setCellValue("E{$dong}", $item['hoten'] . '(' . $item['dien_thoai'] . ')')
                            ->setCellValue("F{$dong}", $item['tong_tien'])
                            ->setCellValue("G{$dong}", $item['trang_thai'])
                            ->setCellValue("H{$dong}", $item['tong_tien'] - $item['da_thanh_toan']);
                        $activeSheet->getStyle("A{$dong}:I{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }

                    break;

                case 'PHÒNG Ở':
                    $activeSheet->setCellValue("A1", "BÁO CÁO PHÒNG Ở THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    $phong_os = $data['phong_o'];

                    foreach ($phong_os as $index => $item){
                        if(is_null($item['ma_hop_dong'])){
                            $str = 'Đang đợi khách';
                        }else{
                            $inputTime = strtotime($item['thoi_gian_hop_dong_den']);
                            $limitTime = strtotime("+1 month +30 days");
                            $currentTime = time();

                            if($inputTime > $limitTime){
                                $str = 'Kết thúc vào '.date('d/m/Y',$inputTime);
                            }else{
                                $daysLeft = ceil(($inputTime - $currentTime) / (60 * 60 * 24)) + 1;
                                $str = 'Sắp hết hạn (Còn '.$daysLeft.' ngày)';
                            }
                        }
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", $item['name'])
                            ->setCellValue("C{$dong}", $str)
                            ->setCellValue("D{$dong}", $item['ma_hop_dong']);
                        $activeSheet->getStyle("A{$dong}:E{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;

                case 'CHI PHÍ MÔI GIỚI':
                    $activeSheet->setCellValue("A1", "THỐNG KÊ CHI PHÍ MÔI GIỚI THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    $chi_phi_moi_giois = $data['chi_phi_moi_gioi'];
                    foreach ($chi_phi_moi_giois as $index => $item){
                        $str = $item['da_thanh_toan_moi_gioi'] == 0 ? 'Chưa thanh toán' : ($item['da_thanh_toan_moi_gioi'] < $item['so_tien_moi_gioi'] ? 'TT một phần' : 'Đã thanh toán');
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", $item['ma_hop_dong'])
                            ->setCellValue("B{$dong}", $item['ten_phong'])
                            ->setCellValue("D{$dong}", $item['hoten_sale'].'('.$item['dien_thoai_sale'].')')
                            ->setCellValue("E{$dong}", $item['so_tien_moi_gioi'])
                            ->setCellValue("F{$dong}", $str)
                            ->setCellValue("G{$dong}", $item['so_tien_moi_gioi'] - $item['da_thanh_toan_moi_gioi']);
                        $activeSheet->getStyle("A{$dong}:I{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;

                case 'CHI PHÍ KHÁC':
                    $activeSheet->setCellValue("A1", "THỐNG KÊ PHIẾU CHI THỜI GIAN TỪ {$fromDate} ĐẾN {$toDate}");
                    $chi_phi_khacs = $data['chi_phi_khac'];
                    foreach ($chi_phi_khacs as $index => $item){
                        $activeSheet->setCellValue("A{$dong}", $index + 1)
                            ->setCellValue("B{$dong}", date("d/m/Y H:i:s", strtotime($item['created'])))
                            ->setCellValue("C{$dong}", $item['tong_tien']);
                        $activeSheet->getStyle("A{$dong}:D{$dong}")->applyFromArray($borderStyle);
                        $dong++;
                    }
                    break;
            }
        }

    }
    public function run(){
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load(dirname(dirname(__DIR__)) . '/common/template/MAU_BAO_CAO_THONG_KE.xlsx');
        $activeSheet = $objPHPExcel->getActiveSheet();
        $this->renderBody($objPHPExcel);
        $this->filename = time().'-TONG_HOP_BAO_CAO_THONG_KE_TU'.$this->from_date.'-'.$this->to_date.'.xlsx';
        $this->path_file.=$this->filename;
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Xlsx'); //\PHPExcel_IOFactory::createWriter($objPHPExcel, $this->exportType);
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

<?php
namespace common\models;
/**
 * @property \PHPExcel $objPHPExcel
 */

use backend\models\DanhMuc;
use backend\models\PhongBanThucHienThamDinh;
use backend\models\ThucHienCongViec;
use backend\models\ThucHienCvXinYKienLanhDao;
use backend\models\TrangThaiThucHienCv;
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

class exportBaoCaoDanhGiaChiTieuNam
{
    public $tieu_de;
    public $thoi_gian;
    public $namBaoCao;
    public $data;
    /** @var DanhMuc $phong_ban */
    public $phong_ban;
    public $path_file;
    public $fileName;

    public $endColumn;
    public $headerFile;
    //Document properties
    public $creator = 'ANDIN JSC';
    public $title = 'DE XUAT CONG VIEC';
    public $subject = 'DE XUAT CONG VIEC';
    public $description = '';
    public $category = '';
    public $lastModifiedBy = 'ANDIN JSC';
    public $keywords = '';
    public $sheetTitle = 'DE XUAT CONG VIEC';
    public $legal = 'DE XUAT CONG VIEC';
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

  const QUY_I = 'Quý I';
  const QUY_II = 'Quý II';
  const QUY_III = 'Quý III';
  const QUY_IV = 'Quý IV';
  public static $objPHPExcel;
    public static $activeSheet;

    public $indexCotCuoiCung = 17;

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
        self::$objPHPExcel->createSheet()->setTitle("DE XUAT CONG VIEC");
        self::$objPHPExcel->setActiveSheetIndexByName("DE XUAT CONG VIEC");
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
     * @param $activeSheet \PHPExcel_Worksheet
     */
    public function renderBody($activeSheet){
        $activeSheet->setCellValue("A1", $this->tieu_de);
        $activeSheet->setCellValue("A2", $this->phong_ban->name);
        $dong = 6;
        $stt = 1;
        $cotBatDau = 17;
        if(count($this->data) > 0){
          $duLieuDanhGiaChiTieu = $this->data[0]['json_danh_gia_chi_tieu'];
          if($duLieuDanhGiaChiTieu != ''){
            $obj = json_decode($duLieuDanhGiaChiTieu);
            $indexCot = $cotBatDau;
            $mauBaoCaoPhongBan = null;
            foreach ($obj as $item){
              if($item->id == $this->phong_ban->id){
                $mauBaoCaoPhongBan = $item;
                break;
              }
            }

            // Điền mô tả vào các cột
            if(!is_null($mauBaoCaoPhongBan)){
              foreach ($mauBaoCaoPhongBan->moTa as $item){
                if(count($item->moTaCap2) > 0){
                  $activeSheet->setCellValue($this->columnName($indexCot).'3', $item->moTaCap1);
                  $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
                  $activeSheet->setCellValue($this->columnName($indexCot + 1).'5', 'TP ĐG');
                  $activeSheet->getColumnDimension($this->columnName($indexCot))->setWidth(10);
                  $activeSheet->getColumnDimension($this->columnName($indexCot+1))->setWidth(10);
                  $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'3');
                  // Điền điểm cao nhất của mô tả Cấp 1
                  $diemCaoNhat = $item->diemMoTaCap2[0];
                  foreach ($item->diemMoTaCap2 as $itemDiem)
                    if($diemCaoNhat < $itemDiem)
                      $diemCaoNhat = $itemDiem;

                  $activeSheet->setCellValue($this->columnName($indexCot).'4', 'Điểm tối đa: '.$diemCaoNhat);
                  $activeSheet->mergeCells($this->columnName($indexCot).'4:'.$this->columnName($indexCot + 1).'4');
                  $indexCot+=2;
                }
              }
              $activeSheet->setCellValue($this->columnName($indexCot).'3', 'NHẬN XÉT CHUNG');
              $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'4');
              $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
              $activeSheet->setCellValue($this->columnName($indexCot+1).'5', 'TP ĐG');
              $indexCot += 2;
              $activeSheet->setCellValue($this->columnName($indexCot).'3', 'NHỮNG ĐIỂM CẦN PHÁT HUY');
              $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'4');
              $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
              $activeSheet->setCellValue($this->columnName($indexCot+1).'5', 'TP ĐG');
              $indexCot += 2;
              $activeSheet->setCellValue($this->columnName($indexCot).'3', 'NHỮNG ĐIỂM CẦN CẢI THIỆN');
              $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'4');
              $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
              $activeSheet->setCellValue($this->columnName($indexCot+1).'5', 'TP ĐG');
              $indexCot += 2;
              $activeSheet->setCellValue($this->columnName($indexCot).'3', 'ĐỀ XUẤT (mức lương, kế hoạch đào tạo, …)');
              $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'4');
              $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
              $activeSheet->setCellValue($this->columnName($indexCot+1).'5', 'TP ĐG');
              $indexCot += 2;
              $activeSheet->setCellValue($this->columnName($indexCot).'3', 'ĐỊNH HƯỚNG CÔNG VIỆC, KẾ HOẠCH PHÁT TRIỂN BẢN THÂN');
              $activeSheet->mergeCells($this->columnName($indexCot).'3:'.$this->columnName($indexCot + 1).'4');
              $activeSheet->setCellValue($this->columnName($indexCot).'5', 'Tự ĐG');
              $activeSheet->setCellValue($this->columnName($indexCot+1).'5', 'TP ĐG');
              $this->indexCotCuoiCung = $indexCot + 1;
            }
            $activeSheet->getRowDimension(3)->setRowHeight(80);
          }

          $dong = 6;
          foreach ($this->data as $item){
            $activeSheet->setCellValue('A'.$dong, $stt);
            $activeSheet->setCellValue('B'.$dong, $item['hoten']);
            if($item['json_content'] != '' && !is_null($item['json_content'])){
              $jsonContent = json_decode($item['json_content']);
              $activeSheet->setCellValue('C'.$dong, $jsonContent->diem_tb_tu_danh_gia);
              $activeSheet->setCellValue('D'.$dong, $jsonContent->diem_tb_tp_danh_gia);
              $activeSheet->setCellValue('E'.$dong, $jsonContent->mau_b_tong_diem_tu_danh_gia);
              $activeSheet->setCellValue('F'.$dong, $jsonContent->mau_b_tong_diem_tp_danh_gia);
              $activeSheet->setCellValue('G'.$dong, "=C{$dong}*70%+E{$dong}*30%");
              $activeSheet->setCellValue('H'.$dong, "=D{$dong}*70%+F{$dong}*30%");

              // Điền điểm theo quý
              // Tính điểm tb của nhân viên trong phòng ban trong năm qua
              $query = "select t2.quy, sum(t.tu_danh_gia) as tuDanhGia, sum(t.boss_danh_gia) as tpDanhGia
                from qlcvsd_ke_hoach_cv_nhan_vien t left join qlcvsd_lap_ke_hoach t2 on t2.id = t.ke_hoach_id
                where  t2.nam = :nam and t.nhan_vien_phong_ban_id = :nvienPhongBan and t.active = 1
                group by t2.quy;";

              $dataThongKeQuy = \Yii::$app->db->createCommand($query, [
                ':nam' => $this->namBaoCao,
                ':nvienPhongBan' => $item['id'],
              ])->queryAll();

              $quy = [self::QUY_I => '', self::QUY_II => '', self::QUY_III => '', self::QUY_IV => ''];
              foreach ($dataThongKeQuy as $itemThongKeQuy){
                if($itemThongKeQuy['quy'] == self::QUY_I){
                  $activeSheet->setCellValue('I'.$dong, $itemThongKeQuy['tuDanhGia']);
                  $activeSheet->setCellValue('J'.$dong, $itemThongKeQuy['tpDanhGia']);
                }
                else if($itemThongKeQuy['quy'] == self::QUY_II){
                  $activeSheet->setCellValue('K'.$dong, $itemThongKeQuy['tuDanhGia']);
                  $activeSheet->setCellValue('L'.$dong, $itemThongKeQuy['tpDanhGia']);
                }
                else if($itemThongKeQuy['quy'] == self::QUY_III){
                  $activeSheet->setCellValue('M'.$dong, $itemThongKeQuy['tuDanhGia']);
                  $activeSheet->setCellValue('N'.$dong, $itemThongKeQuy['tpDanhGia']);
                }
                else if($itemThongKeQuy['quy'] == self::QUY_IV){
                  $activeSheet->setCellValue('O'.$dong, $itemThongKeQuy['tuDanhGia']);
                  $activeSheet->setCellValue('P'.$dong, $itemThongKeQuy['tpDanhGia']);
                }
              }


              $indexInnerIndexCot = $cotBatDau;

              $strTudDanhGia = '=';
              $strTPdDanhGia = '=';

              foreach ($jsonContent->diemTuDanhGiaNhom1 as $indexTuDanhGia => $itemTuDanhGia){
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $itemTuDanhGia->diemTuDanhGia);
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot+1).$dong, $jsonContent->diemQLDanhGiaNhom1[$indexTuDanhGia]->diem);

                $strTudDanhGia .= $this->columnName($indexInnerIndexCot).$dong .($indexTuDanhGia == count($jsonContent->diemTuDanhGiaNhom1) - 1 ? '' : '+');
                $strTPdDanhGia .= $this->columnName($indexInnerIndexCot+1).$dong .($indexTuDanhGia == count($jsonContent->diemTuDanhGiaNhom1) - 1 ? '' : '+');

                $indexInnerIndexCot+=2;
              }

              $backupIndexInnerIndexCot = $indexInnerIndexCot;

              if($item['json_noi_dung_khac_nv'] != '' && !is_null($item['json_noi_dung_khac_nv'])){
                $json_noi_dung_khac_nv = json_decode($item['json_noi_dung_khac_nv']);
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhanXetChung);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhungDiemCanPhatHuy);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhungDiemCanCaiThien);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->deXuat);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->dinhHuong);
              }

              $indexInnerIndexCot = $backupIndexInnerIndexCot + 1;
              if($item['json_noi_dung_khac_tp'] != '' && !is_null($item['json_noi_dung_khac_tp'])){
                $json_noi_dung_khac_nv = json_decode($item['json_noi_dung_khac_tp']);
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhanXetChung);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhungDiemCanPhatHuy);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->nhungDiemCanCaiThien);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->deXuat);
                $indexInnerIndexCot += 2;
                $activeSheet->setCellValue($this->columnName($indexInnerIndexCot).$dong, $json_noi_dung_khac_nv->dinhHuong);
              }

//              $activeSheet->setCellValue($this->columnName($indexInnerIndexCot), $strTudDanhGia);

              $activeSheet->setCellValue("E".$dong, $strTudDanhGia);
              $activeSheet->setCellValue("F".$dong, $strTPdDanhGia);
            }
            $stt++;
            $dong++;
          }
//          Border
          $activeSheet->getStyle('A3:'.$this->columnName($this->indexCotCuoiCung).($dong-1))
            ->applyFromArray(
              array(
                'borders' => array(
                  'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
//                    'color' => array('rgb' => 'DDDDDD')
                  )
                ),
                'font'  => array(
                  'name'  => 'Times New Roman'
                )
              )
            );
//          $styleArray = array(
//            'font'  => array(
//              'name'  => 'Times New Roman'
//            ));
//          $activeSheet->setMergeCells('A1:'.$this->columnName($this->indexCotCuoiCung).'1');
//          $activeSheet->setMergeCells('A2:'.$this->columnName($this->indexCotCuoiCung).'2');
        }
        else
          $activeSheet->setCellValue('A'.$dong, 'KHÔNG CÓ DỮ LIỆU');

    }

    public function run()
    {
      $objPHPExcel = \PHPExcel_IOFactory::load(dirname(dirname(__DIR__)).'/common/template/MAU-BAO-CAO-DANH-GIA-CHI-TIEU.xlsx');
        $activeSheet = $objPHPExcel->getActiveSheet();
        $this->renderBody($activeSheet);
        $this->filename = $this->fileName.'.xlsx';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $this->exportType);
        $objWriter->setPreCalculateFormulas(true);

        if (!$this->stream) {
            $objWriter->save($this->path_file.'.xlsx');
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

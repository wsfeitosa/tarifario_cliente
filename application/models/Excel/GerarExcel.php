<?php
set_time_limit(0);

class Application_Model_Excel_GerarExcel  {
	
	const TEMPLATE = "/var/www/html/allink/Clientes/tarifario/Relatorios/tarifario_cliente/templates/template.xls";
	const LIBPHPEXCEL = "/var/www/html/allink/Libs/php_excel/Classes/";
	
	protected $meses = Array(
							 1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4=> "Abril",
							 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto",
							 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro",
	);
	
	public function __construct()
	{
		
	}
	
	public function GerarExcel(Zend_Db_Table_Rowset $tarifarios)
	{
				
		require_once self::LIBPHPEXCEL."PHPExcel.php";
				
		$phpexcel = PHPExcel_IOFactory::load(self::TEMPLATE);
		
		$activeSheet = $phpexcel->getActiveSheet();
						
		$cabecalho_excel = NULL;
		
		if( $tarifarios->current()->modulo == "IMP" )
		{
			$cabecalho_excel = "TARIFARIO LCL IMPORTAÇÃO " . strtoupper($this->meses[date('n')] . " ". date("Y")); 
		}
		else 
		{
			$cabecalho_excel = "TARIFARIO LCL EXPORTAÇÃO " . strtoupper($this->meses[date('n')] . " ". date("Y"));
		}	
		
		$activeSheet->setCellValue("B1",utf8_encode($cabecalho_excel));
						
		$linha = 5;
		
		foreach( $tarifarios as $tarifario )
		{
			$row = array("SANTOS","SANTOS","HAMBURG","HAMBURG");
						
			$activeSheet->fromArray($row, NULL, 'A' . $linha);
			
			$activeSheet->setCellValue("A".$linha, "SANTOS");			
			$activeSheet->setCellValue("B".$linha, "SANTOS");
			$activeSheet->setCellValue("C".$linha, "HAMBURG");
			$activeSheet->setCellValue("D".$linha, "HAMBURG");			
			$activeSheet->setCellValue("E".$linha, "");
			$activeSheet->setCellValue("F".$linha, "GERMANY");			
			$activeSheet->getCell("G".$linha)->setValueExplicit("USD", PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->getCell("H".$linha)->setValueExplicit(sprintf("%01.2f", "7.00"), PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->getCell("I".$linha)->setValueExplicit(sprintf("%01.2f", "7.00"), PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->getCell("J".$linha)->setValueExplicit(sprintf("%01.2f", "2.00"), PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->getCell("K".$linha)->setValueExplicit(sprintf("%01.2f", "5.00"), PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->setCellValue("L".$linha, "");
			$activeSheet->setCellValue("M".$linha, "SEE SPECIFIC CHARGES");
			$activeSheet->getCell("N".$linha)->setValueExplicit("5", PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->setCellValue("O".$linha, "SEMANAL");
			$activeSheet->getCell("P".$linha)->setValueExplicit("23", PHPExcel_Cell_DataType::TYPE_STRING);
			$activeSheet->setCellValue("Q".$linha, "QUINZENAL");
			$activeSheet->setCellValue("R".$linha, "SACO_SHIPPING");
			$activeSheet->setCellValue("S".$linha, "SEE ADDITIONAL INFORMATION");
			$activeSheet->setCellValue("T".$linha, "1" . ' = ' . "1000");
			$activeSheet->setCellValue("U".$linha, date('d/m/Y'));
			$activeSheet->setCellValue("V".$linha, date('d/m/Y'));
				
			$activeSheet->getCell("S".$linha)->getHyperlink('"SEE ADDITIONAL INFORMATION"')->setUrl('http://'.$_SERVER['SERVER_ADDR']."/Clientes/tarifario/aditional_information.php?key=".$linha);
			$activeSheet->getCell("M".$linha)->getHyperlink('"SEE SPECIFIC CHARGES"')->setUrl('http://'.$_SERVER['SERVER_ADDR']."/Clientes/tarifario/specific_charges.php?key=".$linha);
			
			$linha++;
					
		}	

		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( ' memoryCacheSize ' => '128MB');
		if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings))
		{	
			die('PHPExcel caching error');
		}
		
		$phpexcel_writer = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
		
		header('Content-Type: application/vnd.ms-excel;charset=ISO-8859-1');
		header('Content-Disposition: attachment;filename="tarifario.xls"');
		header('Cache-Control: max-age=0');
		$phpexcel_writer->save('php://output');
							
	}
	
	/**
	 * getExcelStyles
	 *
	 * Obtem stylos personalizados para aplicar na planiha do tariário
	 *
	 * @name getExcelStyles
	 * @access public
	 * @param string $style_name
	 * @return Array $style
	 */
	protected function getExcelStyles($style_name = NULL)
	{
	
		if( is_null($style_name) )
		{
			throw new InvalidArgumentException("O nome do estilo informado não corresponde a nenhum estilo existente!");
		}
	
		$styles = Array();
	
		$styles['green'] = Array(
				'font' => array(
						"size"=>"8",
						'bold'=>true,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_BLACK ),
						'align' => "center"
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => '98FB98'
						)
				)
		);
	
		$styles['red'] = Array(
				'font' => array(
						"size"=>"12",
						'bold'=>true,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_WHITE ),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FF0000'
						)
				)
		);
	
		$styles['dark_blue'] = Array(
				'font' => array(
						"size"=>"10",
						'bold'=>true,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_WHITE ),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => '1f497d'
						)
				)
	
		);
	
		$styles['light_blue'] = Array(
				'font' => array(
						"size"=>"8",
						'bold'=>true,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_BLACK ),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'b9cde5'
						)
				)
	
		);
	
		$styles['white'] = Array(
				'font' => array(
						"size" => "8",
						'bold' => false,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_BLACK ),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFFFF'
						)
				)
	
		);
	
		$styles['yellow'] = Array(
				'font' => array(
						"size" => "8",
						'bold' => true,
						'color' => array( 'argb' => PHPExcel_Style_Color::COLOR_BLACK ),
				),
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFF99'
						)
				)
					
		);
	
		return $styles[$style_name];
	
	}
	
}

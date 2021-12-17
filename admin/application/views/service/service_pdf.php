<?php

$html = '
		<h3>Service List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow"> 
					<th>Name</th>
					<th>Icon</th>
					<th>Sort Description</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_services as $row):
			$html .= '		
				<tr class="oddrow"> 
					<td>'.$row['name'].'</td>
					<td><img src="'.base_url($row['icon']).'" style="width:50px;" /></td>
					<td>'.$row['sort_description'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Service List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'service_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>
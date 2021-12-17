<?php

$html = '
		<h3>Term List</h3>
		<table border="1" style="width:100%">
			<thead>
				<tr class="headerrow"> 
					<th>Name</th>
					<th>Designation</th>
					<th>Department</th> 
					<th>Created Date</th>
				</tr>
			</thead>
			<tbody>';

			foreach($all_teams as $row):
			$html .= '		
				<tr class="oddrow"> 
					<td>'.$row['name'].'</td>
					<td>'.$row['designation'].'</td>
					<td>'.$row['department'].'</td> 
					<td>'.$row['created_at'].'</td>
				</tr>';
			endforeach;

			$html .=	'</tbody>
			</table>			
		 ';
				
		$mpdf = new mPDF('c');

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("Admin - Term List");
		$mpdf->SetAuthor("AYT");
		$mpdf->watermark_font = 'AYT';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');		 
		 

		$mpdf->WriteHTML($html);

		$filename = 'term_list1';

		ob_clean();

		$mpdf->Output($filename . '.pdf', 'D');

		exit();

?>